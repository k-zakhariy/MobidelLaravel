<?php

namespace Zakhariy\MobidelLaravel;

use Exception;
use Illuminate\Http\Request;
use Illuminate\Log\Logger;
use Psr\Log\LoggerInterface;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Zakhariy\MobidelLaravel\Events\ChangeOrderEvent;

class MobidelCallback
{
    private $dispatcher;
    private $logger;
    private $availableEvents = [];
    private $actionEventsMapping = [];

    /**
     * MobidelCallback constructor.
     * @param EventDispatcherInterface $dispatcher
     * @param Logger $logger
     */
    public function __construct(EventDispatcherInterface $dispatcher, LoggerInterface $logger)
    {
        $this->dispatcher = $dispatcher;
        $this->logger = $logger;

        $this->availableEvents = [
            ChangeOrderEvent::getEventName() // onChangeOrder
        ];

        $this->actionEventsMapping = [
            ChangeOrderEvent::getEventName() => ChangeOrderEvent::class
        ];
    }

    /**
     * @param $listener
     * @param array $actions
     * @throws Exception
     */
    public function subscribeToEvents($listener, $actions = [])
    {
        foreach ($actions as $action) {
            if (!in_array($action, array_keys($this->availableEvents))) {
                throw new Exception('Incorrect event action');
            }
            $this->dispatcher->addListener($action, [$listener, 'on' . ucfirst($action)]);
        }
    }


    public function handleRequest(Request $request)
    {
        $this->logger->info('[MobidelCallback] - Incoming request', $request->all());
        $response = $this->prepareRequest($request);
        if(!empty($response)){
            $this->dispatcher->dispatch($request['action'], $this->getEventByAction($request['action'], $response));
        }
    }


    private function getEventByAction($action, $data)
    {
        $className = $this->actionEventsMapping[$action] ?? null;
        return $className ? new $className($data) : null;
    }

    /**
     * @param Request $request
     * @return bool|mixed
     */
    private function prepareRequest(Request $request)
    {
        try {
            $response = json_decode($request->getContent(), true);

            if (!isset($response) || !isset($response['reqID'])) {
                $this->logger->warning('[MobidelCallback] - Incorrect reqID');
                return false;
            }

            if ((isset($response["action"]) && $response["action"] !== "changeOrder") || !in_array($response["action"], array_keys($this->availableEvents))) {
                $this->logger->warning('[MobidelCallback] - Incorrect action - "' . $response["action"] . '"');
                return false;
            }

            if (md5($response['reqID'] . ":" . env('CRM_LOGIN') . ":" . env('CRM_PASSWORD')) !== $response['SignatureValue']) {
//                $this->logger->warning('[MobidelCallback] - Auth has been failed');
//                return false;
            }

            return $response;

        } catch (Exception $exception) {
            $this->logger->error('[MobidelCallback] - ' . $exception->getMessage(), $exception->getTrace());
            return false;
        }
    }


}
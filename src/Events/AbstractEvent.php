<?php


namespace Zakhariy\MobidelLaravel\Events;

use Symfony\Component\EventDispatcher\Event;
use Zakhariy\MobidelLaravel\Events\CallbackResponse;

abstract class AbstractEvent extends Event
{
    private $callbackResponse;

    /**
     * ChangeOrderEvent constructor.
     * @param $data
     */

    abstract static function getEventName();

    public function __construct($data)
    {
        $this->callbackResponse = new CallbackResponse(
            $data['action'],
            $data['status'],
            $data['orderID'],
            $data['reqID'],
            $data['sessionID'],
            $data['SignatureValue']
        );
    }

    /**
     * @return CallbackResponse
     */
    public function getCallbackResponse(): CallbackResponse
    {
        return $this->callbackResponse;
    }


}
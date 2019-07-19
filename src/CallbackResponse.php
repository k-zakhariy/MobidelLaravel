<?php


namespace Zakhariy\MobidelLaravel\Events;


class CallbackResponse
{
    private $action;
    private $status;
    private $orderID;
    private $reqID;
    private $sessionID;
    private $signatureValue;

    /**
     * CallbackResponse constructor.
     * @param $action
     * @param $status
     * @param $orderID
     * @param $reqID
     * @param $sessionID
     * @param $signatureValue
     */
    public function __construct($action, $status, $orderID, $reqID, $sessionID, $signatureValue)
    {
        $this->action = $action;
        $this->status = $status;
        $this->orderID = $orderID;
        $this->reqID = $reqID;
        $this->sessionID = $sessionID;
        $this->signatureValue = $signatureValue;
    }


    /**
     * @return mixed
     */
    public function getAction()
    {
        return $this->action;
    }

    /**
     * @param mixed $action
     */
    public function setAction($action): void
    {
        $this->action = $action;
    }

    /**
     * @return mixed
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * @param mixed $status
     */
    public function setStatus($status): void
    {
        $this->status = $status;
    }

    /**
     * @return mixed
     */
    public function getOrderID()
    {
        return $this->orderID;
    }

    /**
     * @param mixed $orderID
     */
    public function setOrderID($orderID): void
    {
        $this->orderID = $orderID;
    }

    /**
     * @return mixed
     */
    public function getReqUD()
    {
        return $this->reqUD;
    }

    /**
     * @param mixed $reqID
     */
    public function setReqUD($reqID): void
    {
        $this->reqUD = $reqID;
    }

    /**
     * @return mixed
     */
    public function getSessionID()
    {
        return $this->sessionID;
    }

    /**
     * @param mixed $sessionID
     */
    public function setSessionID($sessionID): void
    {
        $this->sessionID = $sessionID;
    }

    /**
     * @return mixed
     */
    public function getSignatureValue()
    {
        return $this->signatureValue;
    }

    /**
     * @param mixed $signatureValue
     */
    public function setSignatureValue($signatureValue): void
    {
        $this->signatureValue = $signatureValue;
    }


}
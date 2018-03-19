<?php

namespace TomCan\CombellApi\Structure\Dns;


class DnsSRVRecord extends AbstractDnsRecord
{

    private $service;
    private $target;
    private $protocol;
    private $port;
    private $weight;
    private $priority;

    /**
     * DnsSRVRecord constructor.
     * @param $id
     * @param $hostname
     * @param $ttl
     * @param $priority
     */
    public function __construct($id = "", $hostname = "", $ttl = 3600, $service = "", $target = "", $protocol = "TCP", $priority = 10, $port = 0, $weight = 0)
    {
        parent::__construct($id, 'SRV', $hostname, $ttl);
        $this->setPriority($priority);
    }

    /**
     * @return mixed
     */
    public function getService()
    {
        return $this->service;
    }

    /**
     * @param mixed $service
     */
    public function setService($service)
    {
        $this->service = $service;
    }

    /**
     * @return mixed
     */
    public function getTarget()
    {
        return $this->target;
    }

    /**
     * @param mixed $target
     */
    public function setTarget($target)
    {
        $this->target = $target;
    }

    /**
     * @return mixed
     */
    public function getProtocol()
    {
        return $this->protocol;
    }

    /**
     * @param mixed $protocol
     */
    public function setProtocol($protocol)
    {
        $this->protocol = $protocol;
    }

    /**
     * @return mixed
     */
    public function getPriority()
    {
        return $this->priority;
    }

    /**
     * @param mixed $priority
     */
    public function setPriority($priority)
    {
        $this->priority = $priority;
    }

    /**
     * @return mixed
     */
    public function getPort()
    {
        return $this->port;
    }

    /**
     * @param mixed $port
     */
    public function setPort($port)
    {
        $this->port = $port;
    }

    /**
     * @return mixed
     */
    public function getWeight()
    {
        return $this->weight;
    }

    /**
     * @param mixed $weight
     */
    public function setWeight($weight)
    {
        $this->weight = $weight;
    }

    public function getObject()
    {
        $obj = parent::getObject();
        $obj->service = $this->getService();
        $obj->target = $this->getTarget();
        $obj->protocol = $this->getProtocol();
        $obj->priority = $this->getPriority();
        $obj->port = $this->getPort();
        $obj->weight = $this->getWeight();
        return $obj;
    }

}
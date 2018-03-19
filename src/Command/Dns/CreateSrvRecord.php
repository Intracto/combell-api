<?php

namespace TomCan\CombellApi\Command\Dns;

use TomCan\CombellApi\Command\AbstractCommand;

class CreateSrvRecord extends AbstractCommand
{

    private $domainname;
    private $hostname;
    private $service;
    private $protocol;
    private $priority;
    private $weight;
    private $port;
    private $destination;
    private $ttl;

    public function __construct($domainname, $hostname, $service, $protocol, $priority, $weight, $port, $destination, $ttl)
    {
        parent::__construct("post", "/v2/dns/{domainname}/srvrecords");

        $this->setDomainname($domainname);
        $this->setHostname($hostname);
        $this->setService($service);
        $this->setProtocol($protocol);
        $this->setPriority($priority);
        $this->setWeight($weight);
        $this->setPort($port);
        $this->setDestination($destination);
        $this->setTtl($ttl);
    }

    public function prepare()
    {

        $this->setEndPoint("/v2/dns/".$this->domainname."/srvrecords");

        $obj = new \stdClass();
        $obj->name = $this->hostname;
        $obj->service = $this->service;
        $obj->protocol = $this->protocol;
        $obj->priority = $this->priority;
        $obj->weight = $this->weight;
        $obj->port = $this->port;
        $obj->destination = $this->destination;

        $obj->ttl = $this->ttl;

        $this->setBody(
            json_encode($obj)
        );

    }

    /**
     * @return mixed
     */
    public function getDomainname()
    {
        return $this->domainname;
    }

    /**
     * @param mixed $domainname
     */
    public function setDomainname($domainname)
    {
        $this->domainname = $domainname;
    }

    /**
     * @return mixed
     */
    public function getHostname()
    {
        return $this->hostname;
    }

    /**
     * @param mixed $hostname
     */
    public function setHostname($hostname)
    {
        $this->hostname = $hostname;
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
    public function getDestination()
    {
        return $this->destination;
    }

    /**
     * @param mixed $destination
     */
    public function setDestination($destination)
    {
        $this->destination = $destination;
    }

    /**
     * @return mixed
     */
    public function getTtl()
    {
        return $this->ttl;
    }

    /**
     * @param mixed $ttl
     */
    public function setTtl($ttl)
    {
        $this->ttl = $ttl;
    }

}
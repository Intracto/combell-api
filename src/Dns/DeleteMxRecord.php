<?php

namespace TomCan\CombellApi\Dns;

use TomCan\CombellApi\Common\AbstractCommand;

class DeleteMxRecord extends AbstractCommand
{

    private $domainname;
    private $hostname;
    private $target;
    private $priority;
    private $ttl;

    public function __construct($domainname, $hostname)
    {
        parent::__construct("delete", "/v2/dns/{domainname}/mxrecords/{mxrecord}");

        $this->setDomainname($domainname);
        $this->setHostname($hostname);
    }

    public function prepare()
    {

        $this->setEndPoint("/v2/dns/".$this->domainname."/mxrecords/".$this->getHostname());

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
    public function getPriority()
    {
        return $this->priority;
    }

    /**
     * @param mixed $priority
     */
    public function setPriority($priority)
    {
        $priority = (int)$priority;
        if ($priority < 1 || $priority > 999) {
            throw new \RangeException("Invalid value for priority");
        }
        $this->priority = $priority;
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
        $ttl = (int)$ttl;
        if ($ttl < 60 || $ttl > 86400) {
            throw new \RangeException("Invalid value for ttl");
        }
        $this->ttl = $ttl;
    }

}
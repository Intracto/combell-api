<?php

namespace TomCan\CombellApi\Dns;

use TomCan\CombellApi\Common\AbstractCommand;

class CreateTxtRecord extends AbstractCommand
{

    private $domainname;
    private $hostname;
    private $content;
    private $ttl;

    public function __construct($domainname, $hostname, $content, $ttl)
    {
        parent::__construct("post", "/v2/dns/{domainname}/txtrecords");

        $this->setDomainname($domainname);
        $this->setHostname($hostname);
        $this->setContent($content);
        $this->setTtl($ttl);
    }

    public function prepare()
    {

        $this->setEndPoint("/v2/dns/".$this->domainname."/txtrecords");

        $obj = new \stdClass();
        $obj->record = $this->hostname;
        $obj->content = $this->content;
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
    public function getContent()
    {
        return $this->content;
    }

    /**
     * @param mixed $content
     */
    public function setContent($content)
    {
        $this->content = $content;
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
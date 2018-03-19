<?php

namespace TomCan\CombellApi\Structure\Dns;


class AbstractDnsRecord
{

    protected $id;
    protected $type;
    protected $hostname;
    protected $ttl;

    /**
     * AbstractDnsRecord constructor.
     * @param $id
     * @param $type
     * @param $hostname
     * @param $ttl
     */
    public function __construct($id, $type, $hostname, $ttl)
    {
        $this->id = $id;
        $this->type = $type;
        $this->hostname = $hostname;
        $this->ttl = $ttl;
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return mixed
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * @param mixed $type
     */
    public function setType($type)
    {
        $this->type = $type;
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
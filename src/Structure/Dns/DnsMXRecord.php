<?php

namespace TomCan\CombellApi\Structure\Dns;


class DnsMXRecord extends AbstractDnsRecord
{

    private $content;
    private $priority;

    /**
     * DnsMXRecord constructor.
     * @param $id
     * @param $hostname
     * @param $ttl
     * @param $content
     * @param $priority
     */
    public function __construct($id = "", $hostname = "", $ttl = 3600, $content = "", $priority = 10)
    {
        parent::__construct($id, 'MX', $hostname, $ttl);
        $this->setContent($content);
        $this->setPriority($priority);
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

    public function getObject()
    {
        $obj = parent::getObject();
        $obj->content = $this->getContent();
        $obj->priority = $this->getPriority();
        return $obj;
    }

}
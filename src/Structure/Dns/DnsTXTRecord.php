<?php

namespace TomCan\CombellApi\Structure\Dns;


class DnsTXTRecord extends AbstractDnsRecord
{

    private $content;

    /**
     * DnsTXTRecord constructor.
     * @param $content
     */
    public function __construct($id = "", $hostname = "", $ttl = 3600, $content)
    {
        parent::__construct($id, 'TXT', $hostname, $ttl);
        $this->setContent($content);
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

    public function getObject()
    {
        $obj = parent::getObject();
        $obj->content = $this->getContent();
        return $obj;
    }

}
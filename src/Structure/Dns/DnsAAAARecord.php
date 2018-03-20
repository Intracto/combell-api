<?php

namespace TomCan\CombellApi\Structure\Dns;


class DnsAAAARecord extends AbstractDnsRecord
{

    private $content;

    /**
     * DnsAAAARecord constructor.
     * @param $id
     * @param $hostname
     * @param $ttl
     * @param $content
     */
    public function __construct($id = "", $hostname = "", $ttl = 3600, $content)
    {
        parent::__construct($id, 'AAAA', $hostname, $ttl);
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
        if ($filtered = filter_var($content, FILTER_VALIDATE_IP, FILTER_FLAG_IPV6)) {
            $this->content = $filtered;
        } else {
            throw new \InvalidArgumentException("Not a valid IPv6 address");
        }
    }

    public function getObject()
    {
        $obj = parent::getObject();
        $obj->content = $this->getContent();
        return $obj;
    }

}
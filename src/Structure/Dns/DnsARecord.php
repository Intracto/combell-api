<?php

namespace TomCan\CombellApi\Structure\Dns;


class DnsARecord extends AbstractDnsRecord
{

    private $content;

    /**
     * DnsARecord constructor.
     * @param $content
     */
    public function __construct($id = "", $hostname = "", $ttl = 3600, $content)
    {
        parent::__construct($id, 'A', $hostname, $ttl);
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
        if ($filtered = filter_var($content, FILTER_VALIDATE_IP, FILTER_FLAG_IPV4)) {
            $this->content = $filtered;
        } else {
            throw new \InvalidArgumentException("Not a valid IPv4 address");
        }
    }

    public function getObject()
    {
        $obj = parent::getObject();
        $obj->content = $this->getContent();
        return $obj;
    }

}
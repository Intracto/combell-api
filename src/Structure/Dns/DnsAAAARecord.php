<?php

namespace TomCan\CombellApi\Structure\Dns;

class DnsAAAARecord extends AbstractDnsRecord
{
    private $content;

    public function __construct(string $id = '', string $hostname = '', int $ttl = 3600, string $content = '')
    {
        parent::__construct($id, 'AAAA', $hostname, $ttl);
        $this->setContent($content);
    }

    public function getContent(): string
    {
        return $this->content;
    }

    public function setContent(string $content): void
    {
        $filtered = filter_var($content, FILTER_VALIDATE_IP, FILTER_FLAG_IPV6);

        if ($filtered === false) {
            throw new \InvalidArgumentException('Not a valid IPv6 address');
        }

        $this->content = $filtered;
    }

    public function getObject(): \stdClass
    {
        $obj = parent::getObject();
        $obj->content = $this->getContent();

        return $obj;
    }
}

<?php

namespace TomCan\CombellApi\Structure\Dns;

class DnsARecord extends AbstractDnsRecord
{
    private $content;

    public function __construct(string $id = '', string $hostname = '', int $ttl = 3600, string $content = '')
    {
        parent::__construct($id, 'A', $hostname, $ttl);
        $this->setContent($content);
    }

    public function getContent(): string
    {
        return $this->content;
    }

    private function setContent(string $content): void
    {
        $filtered = filter_var($content, FILTER_VALIDATE_IP, FILTER_FLAG_IPV4);

        if (false === $filtered) {
            throw new \InvalidArgumentException('Not a valid IPv4 address');
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

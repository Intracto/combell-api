<?php

namespace TomCan\CombellApi\Structure\Dns;

class DnsCNAMERecord extends AbstractDnsRecord
{
    private $content;

    public function __construct(string $id = '', string $hostname = '', int $ttl = 3600, string $content)
    {
        parent::__construct($id, 'CNAME', $hostname, $ttl);
        $this->setContent($content);
    }

    public function getContent(): string
    {
        return $this->content;
    }

    public function setContent(string $content): void
    {
        $this->content = $content;
    }

    public function getObject(): \stdClass
    {
        $obj = parent::getObject();
        $obj->content = $this->getContent();

        return $obj;
    }
}

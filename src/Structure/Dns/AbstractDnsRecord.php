<?php

namespace TomCan\CombellApi\Structure\Dns;

class AbstractDnsRecord
{
    protected $id;
    protected $type;
    protected $hostname;
    protected $ttl;

    public function __construct(string $id, string $type, string $hostname, int $ttl)
    {
        $this->id = $id;
        $this->type = $type;
        $this->hostname = $hostname;
        $this->ttl = $ttl;
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function getType(): string
    {
        return $this->type;
    }

    public function getHostname(): string
    {
        return $this->hostname;
    }

    public function getTtl(): int
    {
        return $this->ttl;
    }

    public function getObject(): \stdClass
    {
        $obj = new \stdClass();
        $obj->id = $this->getId();
        $obj->record_name = $this->getHostname();
        $obj->type = $this->getType();
        $obj->ttl = $this->getTtl();

        return $obj;
    }
}

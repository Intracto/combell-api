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

    public function setId(string $id): void
    {
        $this->id = $id;
    }

    public function getType(): string
    {
        return $this->type;
    }

    public function setType(string $type): void
    {
        $this->type = $type;
    }

    public function getHostname(): string
    {
        return $this->hostname;
    }

    public function setHostname(string $hostname): void
    {
        $this->hostname = $hostname;
    }

    public function getTtl(): int
    {
        return $this->ttl;
    }

    public function setTtl(int $ttl): void
    {
        $this->ttl = $ttl;
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

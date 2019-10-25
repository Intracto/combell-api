<?php

namespace TomCan\CombellApi\Structure\Dns;

class DnsSRVRecord extends AbstractDnsRecord
{
    private $service;
    private $target;
    private $protocol;
    private $port;
    private $weight;
    private $priority;

    public function __construct(
        string $id = '',
        string $hostname = '',
        int $ttl = 3600,
        string $service = '',
        string $target = '',
        string $protocol = 'TCP',
        int $priority = 10,
        int $port = 0,
        int $weight = 0
    ) {
        parent::__construct($id, 'SRV', $hostname, $ttl);
        $this->service = $service;
        $this->target = $target;
        $this->protocol = $protocol;
        $this->port = $port;
        $this->weight = $weight;
        $this->priority = $priority;
    }

    public function getService(): string
    {
        return $this->service;
    }

    public function getTarget(): string
    {
        return $this->target;
    }

    public function getProtocol(): string
    {
        return $this->protocol;
    }

    public function getPriority(): int
    {
        return $this->priority;
    }

    public function getPort(): int
    {
        return $this->port;
    }

    public function getWeight(): int
    {
        return $this->weight;
    }

    public function getObject(): \stdClass
    {
        $obj = parent::getObject();
        $obj->service = $this->getService();
        $obj->target = $this->getTarget();
        $obj->protocol = $this->getProtocol();
        $obj->priority = $this->getPriority();
        $obj->port = $this->getPort();
        $obj->weight = $this->getWeight();

        return $obj;
    }
}

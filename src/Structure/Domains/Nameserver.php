<?php

namespace TomCan\CombellApi\Structure\Domains;

class Nameserver
{
    private $name;
    private $ip;

    public function __construct(string $name, ?string $ip = null)
    {
        $this->name = $name;
        $this->ip = $ip;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): void
    {
        $this->name = $name;
    }

    public function getIp(): string
    {
        return $this->ip;
    }

    public function setIp(string $ip): void
    {
        $this->ip = $ip;
    }
}

<?php

namespace TomCan\CombellApi\Structure\LinuxHostings;

class HostHeader
{
    private $name;
    private $enabled;

    public function __construct(string $name, bool $enabled)
    {
        $this->name = $name;
        $this->enabled = $enabled;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function isEnabled(): bool
    {
        return $this->enabled;
    }
}

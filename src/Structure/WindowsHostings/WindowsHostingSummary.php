<?php

namespace TomCan\CombellApi\Structure\WindowsHostings;

class WindowsHostingSummary
{
    private $domainName;
    private $servicepackId;

    public function __construct(string $domainName, int $servicepackId)
    {
        $this->domainName = $domainName;
        $this->servicepackId = $servicepackId;
    }

    public function getDomainName(): string
    {
        return $this->domainName;
    }

    public function getServicepackId(): int
    {
        return $this->servicepackId;
    }
}

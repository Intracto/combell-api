<?php

namespace TomCan\CombellApi\Structure\Domains;

class Domain
{
    private $domainName;
    private $expirationDate;
    private $willRenew;
    private $nameServers;

    public function __construct(
        string $domainName,
        \DateTime $expirationDate,
        ?bool $willRenew = null,
        array $nameServers = []
    ) {
        $this->domainName = $domainName;
        $this->expirationDate = $expirationDate;
        $this->willRenew = $willRenew;
        $this->nameServers = $nameServers;
    }

    public function getDomainName(): string
    {
        return $this->domainName;
    }

    public function getExpirationDate(): \DateTime
    {
        return $this->expirationDate;
    }

    public function getWillRenew(): ?bool
    {
        return $this->willRenew;
    }

    public function getNameServers(): array
    {
        return $this->nameServers;
    }
}

<?php

namespace TomCan\CombellApi\Structure\Domains;

class Domain
{
    private $domainname;
    private $expirationDate;
    private $willRenew;
    private $nameservers;

    public function __construct(string $domainname, \DateTime $expirationDate = null, ?bool $willRenew = null, array $nameservers = [])
    {
        $this->domainname = $domainname;
        $this->expirationDate = $expirationDate;
        $this->willRenew = $willRenew;
        $this->nameservers = $nameservers;
    }

    public function getDomainname(): string
    {
        return $this->domainname;
    }

    public function setDomainname(string $domainname): void
    {
        $this->domainname = $domainname;
    }

    public function getExpirationDate(): \DateTime
    {
        return $this->expirationDate;
    }

    public function setExpirationDate(\DateTime $expirationDate): void
    {
        $this->expirationDate = $expirationDate;
    }

    public function getWillRenew(): ?bool
    {
        return $this->willRenew;
    }

    public function setWillRenew(bool $willRenew): void
    {
        $this->willRenew = $willRenew;
    }

    public function getNameservers(): array
    {
        return $this->nameservers;
    }

    public function setNameservers(array $nameservers): void
    {
        $this->nameservers = $nameservers;
    }
}

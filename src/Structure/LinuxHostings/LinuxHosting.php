<?php

namespace TomCan\CombellApi\Structure\LinuxHostings;

class LinuxHosting
{
    private $domainName;
    private $servicepackId;
    private $maxWebspaceSize;
    private $maxSize;
    private $webspaceUsage;
    private $actualSize;
    private $ip;
    private $ipType;
    private $sshHost;
    private $ftpUserName;
    private $sshUserName;

    public function __construct(
        string $domainName,
        int $servicepackId,
        ?int $maxWebspaceSize = null,
        ?int $maxSize = null,
        ?int $webspaceUsage = null,
        ?int $actualSize = null,
        ?string $ip = null,
        ?string $ipType = null,
        ?string $sshHost = null,
        ?string $ftpUserName = null,
        ?string $sshUserName = null
    ) {
        $this->domainName = $domainName;
        $this->servicepackId = $servicepackId;
        $this->maxWebspaceSize = $maxWebspaceSize;
        $this->maxSize = $maxSize;
        $this->webspaceUsage = $webspaceUsage;
        $this->actualSize = $actualSize;
        $this->ip = $ip;
        $this->ipType = $ipType;
        $this->sshHost = $sshHost;
        $this->ftpUserName = $ftpUserName;
        $this->sshUserName = $sshUserName;
    }

    public function getDomainName(): string
    {
        return $this->domainName;
    }

    public function getServicepackId(): int
    {
        return $this->servicepackId;
    }

    public function getMaxWebspaceSize(): ?int
    {
        return $this->maxWebspaceSize;
    }

    public function getMaxSize(): ?int
    {
        return $this->maxSize;
    }

    public function getWebspaceUsage(): ?int
    {
        return $this->webspaceUsage;
    }

    public function getActualSize(): ?int
    {
        return $this->actualSize;
    }

    public function getIp(): ?string
    {
        return $this->ip;
    }

    public function getIpType(): ?string
    {
        return $this->ipType;
    }

    public function getSshHost(): ?string
    {
        return $this->sshHost;
    }

    public function getFtpHost(): ?string
    {
        return is_null($this->sshUserName) ? null : $this->sshUserName.'.webhosting.be';
    }

    public function getFtpUserName(): ?string
    {
        return $this->ftpUserName;
    }

    public function getSshUserName(): ?string
    {
        return $this->sshUserName;
    }
}

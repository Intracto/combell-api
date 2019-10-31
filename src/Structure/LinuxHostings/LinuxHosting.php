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
    private $phpVersion;
    private $sites;
    private $mysqlDatabaseNames;

    public function __construct(
        string $domainName,
        int $servicepackId,
        int $maxWebspaceSize,
        int $maxSize,
        int $webspaceUsage,
        int $actualSize,
        string $ip,
        string $ipType,
        string $ftpUserName,
        string $sshHost,
        string $sshUserName,
        string $phpVersion,
        array $sites,
        array $mysqlDatabaseNames
    ) {
        $this->domainName = $domainName;
        $this->servicepackId = $servicepackId;
        $this->maxWebspaceSize = $maxWebspaceSize;
        $this->maxSize = $maxSize;
        $this->webspaceUsage = $webspaceUsage;
        $this->actualSize = $actualSize;
        $this->ip = $ip;
        $this->ipType = $ipType;
        $this->ftpUserName = $ftpUserName;
        $this->sshHost = $sshHost;
        $this->sshUserName = $sshUserName;
        $this->phpVersion = $phpVersion;
        $this->sites = $sites;
        $this->mysqlDatabaseNames = $mysqlDatabaseNames;
    }

    public function getDomainName(): string
    {
        return $this->domainName;
    }

    public function getServicepackId(): int
    {
        return $this->servicepackId;
    }

    public function getMaxWebspaceSize(): int
    {
        return $this->maxWebspaceSize;
    }

    public function getMaxSize(): int
    {
        return $this->maxSize;
    }

    public function getWebspaceUsage(): int
    {
        return $this->webspaceUsage;
    }

    public function getActualSize(): int
    {
        return $this->actualSize;
    }

    public function getIp(): string
    {
        return $this->ip;
    }

    public function getIpType(): string
    {
        return $this->ipType;
    }

    public function getSshHost(): string
    {
        return $this->sshHost;
    }

    public function getFtpHost(): string
    {
        return $this->sshUserName.'.webhosting.be';
    }

    public function getFtpUserName(): string
    {
        return $this->ftpUserName;
    }

    public function getSshUserName(): string
    {
        return $this->sshUserName;
    }

    public function getPhpVersion(): string
    {
        return $this->phpVersion;
    }

    /**
     * @return Site[]
     */
    public function getSites(): array
    {
        return $this->sites;
    }

    public function getMysqlDatabaseNames(): array
    {
        return $this->mysqlDatabaseNames;
    }
}

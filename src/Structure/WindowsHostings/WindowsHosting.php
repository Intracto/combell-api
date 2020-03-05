<?php

namespace TomCan\CombellApi\Structure\WindowsHostings;

class WindowsHosting
{
    private $domainName;
    private $servicepackId;
    private $maxSize;
    private $actualSize;
    private $ip;
    private $ipType;
    private $ftpUserName;
    private $frameworkVersion;
    private $sites;
    private $mssqlDatabaseNames;

    public function __construct(
        string $domainName,
        int $servicepackId,
        int $maxSize,
        int $actualSize,
        string $ip,
        string $ipType,
        string $ftpUserName,
        string $frameworkVersion,
        array $sites,
        array $mssqlDatabaseNames
    ) {
        $this->domainName = $domainName;
        $this->servicepackId = $servicepackId;
        $this->maxSize = $maxSize;
        $this->actualSize = $actualSize;
        $this->ip = $ip;
        $this->ipType = $ipType;
        $this->ftpUserName = $ftpUserName;
        $this->frameworkVersion = $frameworkVersion;
        $this->sites = $sites;
        $this->mssqlDatabaseNames = $mssqlDatabaseNames;
    }

    public function getDomainName(): string
    {
        return $this->domainName;
    }

    public function getServicepackId(): int
    {
        return $this->servicepackId;
    }

    public function getMaxSize(): int
    {
        return $this->maxSize;
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

    public function getFtpHost(): string
    {
        return 'windowsftp.webhosting.be';
    }

    public function getFtpUserName(): string
    {
        return $this->ftpUserName;
    }

    public function getFrameworkVersion(): string
    {
        return $this->frameworkVersion;
    }

    /**
     * @return Site[]
     */
    public function getSites(): array
    {
        return $this->sites;
    }

    public function getMssqlDatabaseNames(): array
    {
        return $this->mssqlDatabaseNames;
    }
}

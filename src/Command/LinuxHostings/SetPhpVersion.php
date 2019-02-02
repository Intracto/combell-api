<?php

namespace TomCan\CombellApi\Command\LinuxHostings;

use TomCan\CombellApi\Command\AbstractCommand;

class SetPhpVersion extends AbstractCommand
{
    private $domainName;
    private $phpVersion;

    public function __construct(string $domainName, string $phpVersion)
    {
        parent::__construct('put', '/v2/linuxhostings/{domainname}/phpsettings/version');

        $this->setDomainName($domainName);
        $this->setPhpVersion($phpVersion);
    }

    public function prepare(): void
    {
        $this->setEndPoint('/v2/linuxhostings/' . $this->domainName . '/phpsettings/version');

        $obj = new \stdClass();
        $obj->version = $this->phpVersion;

        $this->setBody((string) json_encode($obj));
    }

    public function getDomainName(): string
    {
        return $this->domainName;
    }

    public function setDomainName(string $domainName): void
    {
        $this->domainName = $domainName;
    }

    public function getPhpVersion(): string
    {
        return $this->phpVersion;
    }

    public function setPhpVersion(string $phpVersion): void
    {
        $this->phpVersion = $phpVersion;
    }
}

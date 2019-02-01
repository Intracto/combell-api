<?php

namespace TomCan\CombellApi\Command\LinuxHostings;

use TomCan\CombellApi\Command\AbstractCommand;

class SetPhpVersion extends AbstractCommand
{
    private $domainname;
    private $phpversion;

    public function __construct(string $domainname, string $phpversion)
    {
        parent::__construct('put', '/v2/linuxhostings/{domainname}/phpsettings/version');

        $this->setDomainname($domainname);
        $this->setPhpversion($phpversion);
    }

    public function prepare(): void
    {
        $this->setEndPoint('/v2/linuxhostings/' . $this->domainname . '/phpsettings/version');

        $obj = new \stdClass();
        $obj->version = $this->phpversion;

        $this->setBody((string) json_encode($obj));
    }

    public function getDomainname(): string
    {
        return $this->domainname;
    }

    public function setDomainname(string $domainname): void
    {
        $this->domainname = $domainname;
    }

    public function getPhpversion(): string
    {
        return $this->phpversion;
    }

    public function setPhpversion(string $phpversion): void
    {
        $this->phpversion = $phpversion;
    }
}

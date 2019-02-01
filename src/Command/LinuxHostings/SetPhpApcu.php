<?php

namespace TomCan\CombellApi\Command\LinuxHostings;

use TomCan\CombellApi\Command\AbstractCommand;

class SetPhpApcu extends AbstractCommand
{
    private $domainname;
    private $apcusize;

    public function __construct(string $domainname, int $apcusize)
    {
        parent::__construct('put', '/v2/linuxhostings/{domainname}/phpsettings/apcu');

        $this->setDomainname($domainname);
        $this->setApcusize($apcusize);
    }

    public function prepare(): void
    {
        $this->setEndPoint('/v2/linuxhostings/' . $this->domainname . '/phpsettings/apcu');

        $obj = new \stdClass();
        $obj->apcu_size = $this->apcusize;

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

    public function getApcusize(): int
    {
        return $this->apcusize;
    }

    public function setApcusize(int $apcusize): void
    {
        $this->apcusize = $apcusize;
    }
}

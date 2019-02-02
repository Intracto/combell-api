<?php

namespace TomCan\CombellApi\Command\LinuxHostings;

use TomCan\CombellApi\Command\AbstractCommand;

class SetPhpApcu extends AbstractCommand
{
    private $domainName;
    private $apcuSize;

    public function __construct(string $domainName, int $apcuSize)
    {
        parent::__construct('put', '/v2/linuxhostings/{domainname}/phpsettings/apcu');

        $this->setDomainName($domainName);
        $this->setApcuSize($apcuSize);
    }

    public function prepare(): void
    {
        $this->setEndPoint('/v2/linuxhostings/' . $this->domainName . '/phpsettings/apcu');

        $obj = new \stdClass();
        $obj->apcu_size = $this->apcuSize;

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

    public function getApcuSize(): int
    {
        return $this->apcuSize;
    }

    public function setApcuSize(int $apcuSize): void
    {
        $this->apcuSize = $apcuSize;
    }
}

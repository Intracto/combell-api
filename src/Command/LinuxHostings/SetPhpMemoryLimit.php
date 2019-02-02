<?php

namespace TomCan\CombellApi\Command\LinuxHostings;

use TomCan\CombellApi\Command\AbstractCommand;

class SetPhpMemoryLimit extends AbstractCommand
{
    private $domainName;
    private $memoryLimit;

    public function __construct(string $domainName, int $memoryLimit)
    {
        parent::__construct('put', '/v2/linuxhostings/{domainname}/phpsettings/memorylimit');

        $this->setDomainName($domainName);
        $this->setMemoryLimit($memoryLimit);
    }

    public function prepare(): void
    {
        $this->setEndPoint('/v2/linuxhostings/' . $this->domainName . '/phpsettings/memorylimit');

        $obj = new \stdClass();
        $obj->memory_limit = $this->memoryLimit;

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

    public function getMemoryLimit(): int
    {
        return $this->memoryLimit;
    }

    public function setMemoryLimit(int $memoryLimit): void
    {
        $this->memoryLimit = $memoryLimit;
    }
}

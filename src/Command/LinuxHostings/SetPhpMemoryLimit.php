<?php

namespace TomCan\CombellApi\Command\LinuxHostings;

use TomCan\CombellApi\Command\AbstractCommand;

class SetPhpMemoryLimit extends AbstractCommand
{
    private $domainname;
    private $memorylimit;

    public function __construct(string $domainname, int $memorylimit)
    {
        parent::__construct('put', '/v2/linuxhostings/{domainname}/phpsettings/memorylimit');

        $this->setDomainname($domainname);
        $this->setMemorylimit($memorylimit);
    }

    public function prepare(): void
    {
        $this->setEndPoint('/v2/linuxhostings/' . $this->domainname . '/phpsettings/memorylimit');

        $obj = new \stdClass();
        $obj->memory_limit = $this->memorylimit;

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

    public function getMemorylimit(): int
    {
        return $this->memorylimit;
    }

    public function setMemorylimit(int $memorylimit): void
    {
        $this->memorylimit = $memorylimit;
    }
}

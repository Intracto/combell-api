<?php

namespace TomCan\CombellApi\Command\LinuxHostings;

use TomCan\CombellApi\Command\AbstractCommand;

class SetPhpMemoryLimit extends AbstractCommand
{
    private $domainName;
    private $memoryLimit;

    public function __construct(string $domainName, int $memoryLimit)
    {
        parent::__construct('put', '/v2/linuxhostings/{domainName}/phpsettings/memorylimit');

        $this->domainName = $domainName;
        $this->memoryLimit = $memoryLimit;
    }

    public function prepare(): void
    {
        $this->setEndPoint('/v2/linuxhostings/'.$this->domainName.'/phpsettings/memorylimit');

        $obj = new \stdClass();
        $obj->memory_limit = $this->memoryLimit;

        $this->setBody((string) json_encode($obj));
    }

    public function processResponse(array $response)
    {
    }
}

<?php

namespace TomCan\CombellApi\Command\LinuxHostings;

use TomCan\CombellApi\Command\AbstractCommand;

class SetPhpVersion extends AbstractCommand
{
    private $domainName;
    private $phpVersion;

    public function __construct(string $domainName, string $phpVersion)
    {
        parent::__construct('put', '/v2/linuxhostings/{domainName}/phpsettings/version');

        $this->domainName = $domainName;
        $this->phpVersion = $phpVersion;
    }

    public function prepare(): void
    {
        $this->setEndPoint('/v2/linuxhostings/'.$this->domainName.'/phpsettings/version');

        $obj = new \stdClass();
        $obj->version = $this->phpVersion;

        $this->setBody((string) json_encode($obj));
    }

    public function processResponse(array $response)
    {
    }
}

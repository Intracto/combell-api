<?php

namespace TomCan\CombellApi\Command\LinuxHostings;

use TomCan\CombellApi\Command\AbstractCommand;

class ConfigureFtp extends AbstractCommand
{
    private $domainName;
    private $enabled;

    public function __construct(string $domainName, bool $enabled)
    {
        parent::__construct('put', '/v2/linuxhostings/{domainName}/ftp/configuration');

        $this->domainName = $domainName;
        $this->enabled = $enabled;
    }

    public function prepare(): void
    {
        $this->setEndPoint('/v2/linuxhostings/'.$this->domainName.'/ftp/configuration');

        $obj = new \stdClass();
        $obj->enabled = $this->enabled;

        $this->setBody((string) json_encode($obj));
    }

    public function processResponse(array $response)
    {
    }
}

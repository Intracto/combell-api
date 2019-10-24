<?php

namespace TomCan\CombellApi\Command\LinuxHostings;

use TomCan\CombellApi\Command\AbstractCommand;

class SetPhpApcu extends AbstractCommand
{
    private $domainName;
    private $apcuSize;
    private $enabled;

    public function __construct(string $domainName, int $apcuSize, bool $enabled)
    {
        parent::__construct('put', '/v2/linuxhostings/{domainName}/phpsettings/apcu');

        $this->domainName = $domainName;
        $this->apcuSize = $apcuSize;
        $this->enabled = $enabled;
    }

    public function prepare(): void
    {
        $this->setEndPoint('/v2/linuxhostings/' . $this->domainName . '/phpsettings/apcu');

        $obj = new \stdClass();
        $obj->apcu_size = $this->apcuSize;
        $obj->enabled = $this->enabled;

        $this->setBody((string) json_encode($obj));
    }

    public function processResponse(array $response)
    {
    }
}

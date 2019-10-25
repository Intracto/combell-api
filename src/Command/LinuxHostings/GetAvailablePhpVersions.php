<?php

namespace TomCan\CombellApi\Command\LinuxHostings;

use TomCan\CombellApi\Command\AbstractCommand;

class GetAvailablePhpVersions extends AbstractCommand
{
    private $domainName;

    public function __construct(string $domainName)
    {
        parent::__construct('get', '/v2/linuxhostings');

        $this->domainName = $domainName;
    }

    public function prepare(): void
    {
        $this->setEndPoint('/v2/linuxhostings/'.$this->domainName.'/phpsettings/availableversions');
    }

    public function processResponse(array $response)
    {
        $phpVersions = [];
        foreach ($response['body'] as $phpVersion) {
            $phpVersions[] = $phpVersion->version;
        }

        return $phpVersions;
    }
}

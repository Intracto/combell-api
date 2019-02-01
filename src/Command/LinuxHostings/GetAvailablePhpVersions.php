<?php

namespace TomCan\CombellApi\Command\LinuxHostings;

use TomCan\CombellApi\Command\AbstractCommand;

class GetAvailablePhpVersions extends AbstractCommand
{
    private $domainname;

    public function __construct($domainname)
    {
        parent::__construct('get', '/v2/linuxhostings');

        $this->domainname = $domainname;
    }

    public function prepare(): void
    {
        $this->setEndPoint('/v2/linuxhostings/' . $this->domainname . '/phpsettings/availableversions');
    }

    public function getDomainname(): string
    {
        return $this->domainname;
    }

    public function setDomainname(string $domainname): void
    {
        $this->domainname = $domainname;
    }
}

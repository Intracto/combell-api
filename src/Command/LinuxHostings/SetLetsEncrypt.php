<?php

namespace TomCan\CombellApi\Command\LinuxHostings;

use TomCan\CombellApi\Command\AbstractCommand;

class SetLetsEncrypt extends AbstractCommand
{
    private $domainname;
    private $hostname;
    private $enabled;

    public function __construct(string $domainname, string $hostname, bool $enabled)
    {
        parent::__construct('put', '/v2/linuxhostings/{domainname}/sslsettings/{hostname}/letsencrypt');

        $this->setDomainname($domainname);
        $this->setHostname($hostname);
        $this->setEnabled($enabled);
    }

    public function prepare(): void
    {
        $this->setEndPoint('/v2/linuxhostings/' . $this->domainname . '/sslsettings/' . $this->hostname . '/letsencrypt');

        $obj = new \stdClass();
        $obj->enabled = $this->enabled;

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

    public function getHostname(): string
    {
        return $this->hostname;
    }

    public function setHostname(string $hostname): void
    {
        $this->hostname = $hostname;
    }

    public function getEnabled(): bool
    {
        return $this->enabled;
    }

    public function setEnabled(bool $enabled): void
    {
        $this->enabled = $enabled;
    }
}

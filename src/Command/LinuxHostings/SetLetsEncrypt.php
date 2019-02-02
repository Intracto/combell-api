<?php

namespace TomCan\CombellApi\Command\LinuxHostings;

use TomCan\CombellApi\Command\AbstractCommand;

class SetLetsEncrypt extends AbstractCommand
{
    private $domainName;
    private $hostname;
    private $enabled;

    public function __construct(string $domainName, string $hostname, bool $enabled)
    {
        parent::__construct('put', '/v2/linuxhostings/{domainname}/sslsettings/{hostname}/letsencrypt');

        $this->setDomainName($domainName);
        $this->setHostname($hostname);
        $this->setEnabled($enabled);
    }

    public function prepare(): void
    {
        $this->setEndPoint('/v2/linuxhostings/' . $this->domainName . '/sslsettings/' . $this->hostname . '/letsencrypt');

        $obj = new \stdClass();
        $obj->enabled = $this->enabled;

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

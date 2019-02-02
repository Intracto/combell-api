<?php

namespace TomCan\CombellApi\Command\LinuxHostings;

use TomCan\CombellApi\Command\AbstractCommand;

class SetGzipCompression extends AbstractCommand
{
    private $domainName;
    private $enabled;

    public function __construct(string $domainName, bool $enabled)
    {
        parent::__construct('put', '/v2/linuxhostings/{domainname}/settings/gzipcompression');

        $this->setDomainName($domainName);
        $this->setEnabled($enabled);
    }

    public function prepare(): void
    {
        $this->setEndPoint('/v2/linuxhostings/' . $this->domainName . '/settings/gzipcompression');

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

    public function getEnabled(): bool
    {
        return $this->enabled;
    }

    public function setEnabled(bool $enabled): void
    {
        $this->enabled = $enabled;
    }
}

<?php

namespace TomCan\CombellApi\Command\LinuxHostings;

use TomCan\CombellApi\Command\AbstractCommand;

class SetGzipCompression extends AbstractCommand
{
    private $domainname;
    private $enabled;

    public function __construct(string $domainname, bool $enabled)
    {
        parent::__construct('put', '/v2/linuxhostings/{domainname}/settings/gzipcompression');

        $this->setDomainname($domainname);
        $this->setEnabled($enabled);
    }

    public function prepare(): void
    {
        $this->setEndPoint('/v2/linuxhostings/' . $this->domainname . '/settings/gzipcompression');

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

    public function getEnabled(): bool
    {
        return $this->enabled;
    }

    public function setEnabled(bool $enabled): void
    {
        $this->enabled = $enabled;
    }
}

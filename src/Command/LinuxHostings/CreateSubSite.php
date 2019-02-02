<?php

namespace TomCan\CombellApi\Command\LinuxHostings;

use TomCan\CombellApi\Command\AbstractCommand;

class CreateSubSite extends AbstractCommand
{
    private $domainName;
    private $subSiteDomainName;
    private $path;

    public function __construct(string $domainName, string $subSiteDomainName, string $path = '')
    {
        parent::__construct('post', '/v2/linuxhostings/{domainname}/subsites');

        $this->setDomainName($domainName);
        $this->setSubSiteDomainName($subSiteDomainName);
        $this->setPath($path);
    }

    public function prepare(): void
    {
        $this->setEndPoint('/v2/linuxhostings/' . $this->domainName . '/subsites');

        $obj = new \stdClass();
        $obj->domain_name = $this->subSiteDomainName;
        $obj->path = $this->path;

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

    public function getSubSiteDomainName(): string
    {
        return $this->subSiteDomainName;
    }

    public function setSubSiteDomainName(string $subSiteDomainName): void
    {
        $this->subSiteDomainName = $subSiteDomainName;
    }

    public function getPath(): string
    {
        return $this->path;
    }

    public function setPath(string $path): void
    {
        $this->path = $path;
    }
}

<?php

namespace TomCan\CombellApi\Command\LinuxHostings;

use TomCan\CombellApi\Command\AbstractCommand;

class CreateSubsite extends AbstractCommand
{
    private $domainname;
    private $subsiteDomainname;
    private $path;

    public function __construct(string $domainname, string $subSiteDomainName, string $path = '')
    {
        parent::__construct('post', '/v2/linuxhostings/{domainname}/subsites');

        $this->setDomainname($domainname);
        $this->setSubsiteDomainname($subSiteDomainName);
        $this->setPath($path);
    }

    public function prepare(): void
    {
        $this->setEndPoint('/v2/linuxhostings/' . $this->domainname . '/subsites');

        $obj = new \stdClass();
        $obj->domain_name = $this->subsiteDomainname;
        $obj->path = $this->path;

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

    public function getSubsiteDomainname(): string
    {
        return $this->subsiteDomainname;
    }

    public function setSubsiteDomainname(string $subsiteDomainname): void
    {
        $this->subsiteDomainname = $subsiteDomainname;
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

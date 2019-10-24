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
        parent::__construct('post', '/v2/linuxhostings/{domainName}/subsites');

        $this->domainName = $domainName;
        $this->subSiteDomainName = $subSiteDomainName;
        $this->path = $path;
    }

    public function prepare(): void
    {
        $this->setEndPoint('/v2/linuxhostings/' . $this->domainName . '/subsites');

        $obj = new \stdClass();
        $obj->domain_name = $this->subSiteDomainName;
        $obj->path = $this->path;

        $this->setBody((string) json_encode($obj));
    }

    public function processResponse(array $response)
    {
    }
}

<?php

namespace TomCan\CombellApi\Command\Domains;

use TomCan\CombellApi\Command\AbstractCommand;

class SetNameservers extends AbstractCommand
{
    private $domainname;
    private $nameservers;

    public function __construct(string $domainname, array $nameservers)
    {
        parent::__construct('put', '/v2/domains/{domainname}/nameservers');

        $this->setDomainname($domainname);
        $this->setNameservers($nameservers);
    }

    public function prepare(): void
    {
        $this->setEndPoint('/v2/domains/' . $this->domainname . '/nameservers');

        $obj = new \stdClass();
        $obj->domain_name = $this->domainname;
        $obj->name_servers = $this->nameservers;

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

    public function getNameservers(): array
    {
        return $this->nameservers;
    }

    public function setNameservers(array $nameservers): void
    {
        $this->nameservers = $nameservers;
    }
}

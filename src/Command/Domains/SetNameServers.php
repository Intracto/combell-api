<?php

namespace TomCan\CombellApi\Command\Domains;

use TomCan\CombellApi\Command\AbstractCommand;

class SetNameServers extends AbstractCommand
{
    private $domainName;
    private $nameServers;

    public function __construct(string $domainName, array $nameServers)
    {
        parent::__construct('put', '/v2/domains/{domainname}/nameservers');

        $this->setDomainName($domainName);
        $this->setNameServers($nameServers);
    }

    public function prepare(): void
    {
        $this->setEndPoint('/v2/domains/' . $this->domainName . '/nameservers');

        $obj = new \stdClass();
        $obj->domain_name = $this->domainName;
        $obj->name_servers = $this->nameServers;

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

    public function getNameServers(): array
    {
        return $this->nameServers;
    }

    public function setNameServers(array $nameServers): void
    {
        $this->nameServers = $nameServers;
    }
}

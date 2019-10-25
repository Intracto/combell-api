<?php

namespace TomCan\CombellApi\Command\Domains;

use TomCan\CombellApi\Command\AbstractCommand;

class SetNameServers extends AbstractCommand
{
    private $domainName;
    private $nameServers;

    public function __construct(string $domainName, array $nameServers)
    {
        parent::__construct('put', '/v2/domains/{domainName}/nameservers');

        $this->domainName = $domainName;
        $this->nameServers = $nameServers;
    }

    public function prepare(): void
    {
        $this->setEndPoint('/v2/domains/'.$this->domainName.'/nameservers');

        $obj = new \stdClass();
        $obj->domain_name = $this->domainName;
        $obj->name_servers = $this->nameServers;

        $this->setBody((string) json_encode($obj));
    }

    public function processResponse(array $response)
    {
    }
}

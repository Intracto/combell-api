<?php

namespace TomCan\CombellApi\Command\Domains;

use TomCan\CombellApi\Command\AbstractCommand;

class RegisterDomain extends AbstractCommand
{
    private $domainName;
    private $nameServers;

    public function __construct(string $domainName, array $nameServers)
    {
        parent::__construct('post', '/v2/domains/registrations');

        $this->domainName = $domainName;
        $this->nameServers = $nameServers;
    }

    public function prepare(): void
    {
        $obj = new \stdClass();
        $obj->domain_name = $this->domainName;
        $obj->name_servers = $this->nameServers;

        $this->setBody((string) json_encode($obj));
    }

    public function processResponse(array $response)
    {
        if (isset($response['headers']['Location'])) {
            return explode('/', $response['headers']['Location'][0])[3];
        }

        return explode('/', $response['headers']['location'][0])[3];
    }
}

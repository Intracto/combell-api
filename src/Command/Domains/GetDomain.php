<?php

namespace TomCan\CombellApi\Command\Domains;

use TomCan\CombellApi\Command\AbstractCommand;
use TomCan\CombellApi\Structure\Domains\Domain;
use TomCan\CombellApi\Structure\Domains\NameServer;

class GetDomain extends AbstractCommand
{
    private $domain;

    public function __construct(string $domain)
    {
        parent::__construct('get', '/v2/domains/{domainName}');

        $this->domain = $domain;
    }

    public function prepare(): void
    {
        $this->setEndPoint('/v2/domains/'.$this->domain);
    }

    public function processResponse(array $response)
    {
        $nameServers = [];
        if (isset($response['body']->name_servers)) {
            foreach ($response['body']->name_servers as $nameServer) {
                $nameServers[] = new NameServer($nameServer->name, $nameServer->ip);
            }
        }

        return new Domain(
            $response['body']->domain_name,
            new \DateTime($response['body']->expiration_date),
            $response['body']->will_renew,
            $nameServers
        );
    }
}

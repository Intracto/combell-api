<?php

namespace TomCan\CombellApi\Command\Domains;

use TomCan\CombellApi\Command\AbstractCommand;
use TomCan\CombellApi\Structure\Domains\Domain;
use TomCan\CombellApi\Structure\Domains\Nameserver;

class GetDomain extends AbstractCommand
{
    private $domain;

    public function __construct(string $domain)
    {
        parent::__construct('get', '/v2/domains/{domainname}');

        $this->domain = $domain;
    }

    public function prepare(): void
    {
        $this->setEndPoint('/v2/domains/' . $this->domain);
    }

    public function processResponse($response)
    {
        $domains = [];
        $domain = $response['body'];

        $dom = new Domain($domain->domain_name, $domain->expiration_date, $domain->will_renew);
        if (isset($domain->name_servers)) {
            $nameServers = [];
            foreach ($domain->name_servers as $name_server) {
                $nameServers[] = new Nameserver($name_server->name, $name_server->ip);
            }
            $dom->setNameServers($nameServers);
        }

        $domains[] = $dom;

        $response['response'] = $domains;

        return $response;
    }
}

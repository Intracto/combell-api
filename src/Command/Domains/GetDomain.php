<?php

namespace TomCan\CombellApi\Command\Domains;

use TomCan\CombellApi\Command\AbstractCommand;
use TomCan\CombellApi\Structure\Domains\Domain;
use TomCan\CombellApi\Structure\Domains\Nameserver;

class GetDomain extends AbstractCommand
{
    private $domain;

    public function __construct($domain)
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
            $nameservers = [];
            foreach ($domain->name_servers as $name_server) {
                $nameservers[] = new Nameserver($name_server->name, $name_server->ip);
            }
            $dom->setNameservers($nameservers);
        }

        $domains[] = $dom;

        $response['response'] = $domains;

        return $response;
    }
}

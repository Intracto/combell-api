<?php

namespace TomCan\CombellApi\Command\Domains;

use TomCan\CombellApi\Command\AbstractCommand;
use TomCan\CombellApi\Structure\Domains\Domain;

class ListDomains extends AbstractCommand
{
    public function __construct()
    {
        parent::__construct('get', '/v2/domains');
    }

    public function processResponse($response)
    {
        $domains = [];
        foreach ($response['body'] as $domain) {
            $dom = new Domain($domain->domain_name, $domain->expiration_date, $domain->will_renew);
            $domains[] = $dom;
        }

        $response['response'] = $domains;

        return $response;
    }
}

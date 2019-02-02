<?php

namespace TomCan\CombellApi\Command\Domains;

use TomCan\CombellApi\Command\PageableAbstractCommand;
use TomCan\CombellApi\Structure\Domains\Domain;

class ListDomains extends PageableAbstractCommand
{
    public function __construct()
    {
        parent::__construct('get', '/v2/domains');
    }

    public function processResponse(array $response)
    {
        $domains = [];
        foreach ($response['body'] as $domain) {
            $domains[] = new Domain(
                $domain->domain_name,
                new \DateTime($domain->expiration_date),
                $domain->will_renew
            );
        }

        return $domains;
    }
}

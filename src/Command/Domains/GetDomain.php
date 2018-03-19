<?php

namespace TomCan\CombellApi\Command\Domains;

use TomCan\CombellApi\Command\AbstractCommand;

class GetDomain extends AbstractCommand
{

    private $domain;

    public function __construct($domain)
    {
        parent::__construct("get", "/v2/domains/{domainname}");

        $this->domain = $domain;

    }

    public function prepare()
    {
        $this->setEndPoint("/v2/domains/" . $this->domain);
    }

}
<?php

namespace TomCan\CombellApi\Domains;

use TomCan\CombellApi\Common\AbstractCommand;

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
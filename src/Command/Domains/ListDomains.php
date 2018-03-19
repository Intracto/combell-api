<?php

namespace TomCan\CombellApi\Command\Domains;

use TomCan\CombellApi\Command\AbstractCommand;

class ListDomains extends AbstractCommand
{

    public function __construct()
    {
        parent::__construct("get", "/v2/domains");
    }

}
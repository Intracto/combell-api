<?php

namespace TomCan\CombellApi\Domains;

use TomCan\CombellApi\Common\AbstractCommand;

class ListDomains extends AbstractCommand
{

    public function __construct()
    {
        parent::__construct("get", "/v2/domains");
    }

}
<?php

namespace TomCan\CombellApi\Command\Servicepacks;

use TomCan\CombellApi\Command\AbstractCommand;

class ListServicepacks extends AbstractCommand
{

    public function __construct()
    {
        parent::__construct("get", "/v2/servicepacks");
    }

}
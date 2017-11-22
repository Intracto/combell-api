<?php

namespace TomCan\CombellApi\Servicepacks;

use TomCan\CombellApi\Common\AbstractCommand;

class ListServicepacks extends AbstractCommand
{

    public function __construct()
    {
        parent::__construct("get", "/v2/servicepacks");
    }

}
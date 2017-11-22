<?php

namespace TomCan\CombellApi\LinuxHostings;

use TomCan\CombellApi\Common\AbstractCommand;

class ListLinuxHostings extends AbstractCommand
{

    public function __construct()
    {
        parent::__construct("get", "/v2/linuxhostings");
    }

}
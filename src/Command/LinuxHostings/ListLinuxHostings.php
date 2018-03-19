<?php

namespace TomCan\CombellApi\Command\LinuxHostings;

use TomCan\CombellApi\Command\AbstractCommand;

class ListLinuxHostings extends AbstractCommand
{

    public function __construct()
    {
        parent::__construct("get", "/v2/linuxhostings");
    }

}
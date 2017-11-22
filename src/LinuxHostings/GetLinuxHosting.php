<?php

namespace TomCan\CombellApi\LinuxHostings;

use TomCan\CombellApi\Common\AbstractCommand;

class GetLinuxHosting extends AbstractCommand
{

    /**
     * @var string
     */
    private $domainname;

    public function __construct($domainname)
    {
        parent::__construct("get", "/v2/accounts");

        $this->domainname = $domainname;

    }

    public function prepare()
    {
        $this->setEndPoint("/v2/linuxhostings/" . $this->domainname);
    }

}
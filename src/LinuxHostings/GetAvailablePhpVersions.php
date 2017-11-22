<?php

namespace TomCan\CombellApi\LinuxHostings;

use TomCan\CombellApi\Common\AbstractCommand;

class GetAvailablePhpVersions extends AbstractCommand
{

    /**
     * @var string
     */
    private $domainname;

    public function __construct($domainname)
    {
        parent::__construct("get", "/v2/linuxhostings");

        $this->domainname = $domainname;

    }

    public function prepare()
    {
        $this->setEndPoint("/v2/linuxhostings/" . $this->domainname . "/phpsettings/availableversions");
    }

    /**
     * @return string
     */
    public function getDomainname()
    {
        return $this->domainname;
    }

    /**
     * @param string $domainname
     */
    public function setDomainname($domainname)
    {
        $this->domainname = $domainname;
    }

}
<?php

namespace TomCan\CombellApi\Command\LinuxHostings;

use TomCan\CombellApi\Command\AbstractCommand;

class SetPhpVersion extends AbstractCommand
{

    private $domainname;
    private $phpversion;

    public function __construct($domainname, $phpversion)
    {
        parent::__construct("put", "/v2/linuxhostings/{domainname}/phpsettings/version");

        $this->setDomainname($domainname);
        $this->setPhpversion($phpversion);
    }

    public function prepare()
    {

        $this->setEndPoint("/v2/linuxhostings/".$this->domainname."/phpsettings/version");

        $obj = new \stdClass();
        $obj->version = $this->phpversion;

        $this->setBody(
            json_encode($obj)
        );

    }

    /**
     * @return mixed
     */
    public function getDomainname()
    {
        return $this->domainname;
    }

    /**
     * @param mixed $domainname
     */
    public function setDomainname($domainname)
    {
        $this->domainname = $domainname;
    }

    /**
     * @return mixed
     */
    public function getPhpversion()
    {
        return $this->phpversion;
    }

    /**
     * @param mixed $phpversion
     */
    public function setPhpversion($phpversion)
    {
        $this->phpversion = $phpversion;
    }

}
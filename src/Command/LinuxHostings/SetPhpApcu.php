<?php

namespace TomCan\CombellApi\Command\LinuxHostings;

use TomCan\CombellApi\Command\AbstractCommand;

class SetPhpApcu extends AbstractCommand
{

    private $domainname;
    private $apcusize;

    public function __construct($domainname, $apcusize)
    {
        parent::__construct("put", "/v2/linuxhostings/{domainname}/phpsettings/apcu");

        $this->setDomainname($domainname);
        $this->setApcusize($apcusize);
    }

    public function prepare()
    {

        $this->setEndPoint("/v2/linuxhostings/".$this->domainname."/phpsettings/apcu");

        $obj = new \stdClass();
        $obj->apcu_size = $this->apcusize;

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
    public function getApcusize()
    {
        return $this->apcusize;
    }

    /**
     * @param mixed $apcusize
     */
    public function setApcusize($apcusize)
    {
        $this->apcusize = $apcusize;
    }

}
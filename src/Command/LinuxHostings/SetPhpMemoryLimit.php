<?php

namespace TomCan\CombellApi\Command\LinuxHostings;

use TomCan\CombellApi\Command\AbstractCommand;

class SetPhpMemoryLimit extends AbstractCommand
{

    private $domainname;
    private $memorylimit;

    public function __construct($domainname, $memorylimit)
    {
        parent::__construct("put", "/v2/linuxhostings/{domainname}/phpsettings/memorylimit");

        $this->setDomainname($domainname);
        $this->setMemorylimit($memorylimit);
    }

    public function prepare()
    {

        $this->setEndPoint("/v2/linuxhostings/".$this->domainname."/phpsettings/memorylimit");

        $obj = new \stdClass();
        $obj->memory_limit = $this->memorylimit;

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
    public function getMemorylimit()
    {
        return $this->memorylimit;
    }

    /**
     * @param mixed $memorylimit
     */
    public function setMemorylimit($memorylimit)
    {
        $this->memorylimit = $memorylimit;
    }

}
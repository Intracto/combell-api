<?php

namespace TomCan\CombellApi\LinuxHostings;

use TomCan\CombellApi\Common\AbstractCommand;

class CreateSubsite extends AbstractCommand
{

    private $domainname;
    private $subsiteDomainname;
    private $path;

    public function __construct($domainname, $subsite_domainname, $path = "")
    {
        parent::__construct("post", "/v2/linuxhostings/{domainname}/subsites");

        $this->setDomainname($domainname);
        $this->setSubsiteDomainname($subsite_domainname);
        $this->setPath($path);
    }

    public function prepare()
    {

        $this->setEndPoint("/v2/linuxhostings/".$this->domainname."/subsites");

        $obj = new \stdClass();
        $obj->domain_name = $this->subsiteDomainname;
        $obj->path = $this->path;

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
    public function getSubsiteDomainname()
    {
        return $this->subsiteDomainname;
    }

    /**
     * @param mixed $subsiteDomainname
     */
    public function setSubsiteDomainname($subsiteDomainname)
    {
        $this->subsiteDomainname = $subsiteDomainname;
    }

    /**
     * @return mixed
     */
    public function getPath()
    {
        return $this->path;
    }

    /**
     * @param mixed $path
     */
    public function setPath($path)
    {
        $this->path = $path;
    }

}
<?php

namespace TomCan\CombellApi\Command\LinuxHostings;

use TomCan\CombellApi\Command\AbstractCommand;

class SetHttp2 extends AbstractCommand
{
    private $domainname;
    private $sitenname;
    private $enabled;

    public function __construct($domainname, $sitename, $enabled)
    {
        parent::__construct("put", "/v2/linuxhostings/{domainname}/sites/{sitename}/http2/configuration");

        $this->setDomainname($domainname);
        $this->setSitename($sitename);
        $this->setEnabled($enabled);
    }

    public function prepare()
    {
        $this->setEndPoint("/v2/linuxhostings/".$this->domainname."/sites/".$this->sitename."/http2/configuration");

        $obj = new \stdClass();
        $obj->enabled = $this->enabled;

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
    public function getSitename()
    {
        return $this->sitename;
    }

    /**
     * @param mixed $sitename
     */
    public function setSitename($sitename)
    {
        $this->sitename = $sitename;
    }

    /**
     * @return mixed
     */
    public function getEnabled()
    {
        return $this->enabled;
    }

    /**
     * @param mixed $enabled
     */
    public function setEnabled($enabled)
    {
        $this->enabled = $enabled;
    }
}


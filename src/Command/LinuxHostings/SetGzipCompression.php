<?php

namespace TomCan\CombellApi\Command\LinuxHostings;

use TomCan\CombellApi\Command\AbstractCommand;

class SetGzipCompression extends AbstractCommand
{

    private $domainname;
    private $enabled;

    public function __construct($domainname, $enabled)
    {
        parent::__construct("put", "/v2/linuxhostings/{domainname}/settings/gzipcompression");

        $this->setDomainname($domainname);
        $this->setEnabled($enabled);
    }

    public function prepare()
    {

        $this->setEndPoint("/v2/linuxhostings/".$this->domainname."/settings/gzipcompression");

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
<?php

namespace TomCan\CombellApi\Command\LinuxHostings;

use TomCan\CombellApi\Command\AbstractCommand;

class AddSshKey extends AbstractCommand
{

    private $domainname;
    private $pubkey;

    public function __construct($domainname, $pubkey)
    {
        parent::__construct("post", "/v2/linuxhostings/{domainname}/ssh/keys");

        $this->setDomainname($domainname);
        $this->setPubkey($pubkey);
    }

    public function prepare()
    {

        $this->setEndPoint("/v2/linuxhostings/".$this->domainname."/ssh/keys");

        $obj = new \stdClass();
        $obj->public_key = $this->pubkey;

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
    public function getPubkey()
    {
        return $this->pubkey;
    }

    /**
     * @param mixed $pubkey
     */
    public function setPubkey($pubkey)
    {
        $this->pubkey = $pubkey;
    }

}
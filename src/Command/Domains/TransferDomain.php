<?php

namespace TomCan\CombellApi\Command\Domains;

use TomCan\CombellApi\Command\AbstractCommand;

class TransferDomain extends AbstractCommand
{

    private $domainname;
    private $authcode;

    public function __construct($domainname, $authcode)
    {
        parent::__construct("post", "/v2/domains/transfers");

        $this->setDomainname($domainname);
        $this->setAuthcode($authcode);
    }

    public function prepare()
    {

        $obj = new \stdClass();
        $obj->domain_name = $this->domainname;
        $obj->auth_code = $this->authcode;


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
    public function getAuthcode()
    {
        return $this->authcode;
    }

    /**
     * @param mixed $authcode
     */
    public function setAuthcode($authcode)
    {
        $this->authcode = $authcode;
    }

}
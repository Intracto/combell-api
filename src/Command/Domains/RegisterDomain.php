<?php

namespace TomCan\CombellApi\Command\Domains;

use TomCan\CombellApi\Command\AbstractCommand;

class RegisterDomain extends AbstractCommand
{

    private $domainname;
    private $nameservers;

    public function __construct($domainname, $nameservers)
    {
        parent::__construct("post", "/v2/domains/registrations");

        $this->setDomainname($domainname);
        $this->setNameservers($nameservers);
    }

    public function prepare()
    {

        $obj = new \stdClass();
        $obj->domain_name = $this->domainname;
        $obj->name_servers = $this->nameservers;


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
    public function getNameservers()
    {
        return $this->nameservers;
    }

    /**
     * @param mixed $nameservers
     */
    public function setNameservers($nameservers)
    {
        $this->nameservers = $nameservers;
    }

}
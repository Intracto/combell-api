<?php

namespace TomCan\CombellApi\Command\Domains;

use TomCan\CombellApi\Command\AbstractCommand;

class SetNameservers extends AbstractCommand
{

    private $domainname;
    private $nameservers;

    public function __construct($domainname, $nameservers)
    {
        parent::__construct("put", "/v2/domains/{domainname}/nameservers");

        $this->setDomainname($domainname);
        $this->setNameservers($nameservers);
    }

    public function prepare()
    {

        $this->setEndPoint("/v2/domains/" . $this->domainname . "/nameservers");

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
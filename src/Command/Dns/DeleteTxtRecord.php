<?php

namespace TomCan\CombellApi\Command\Dns;

use TomCan\CombellApi\Command\AbstractCommand;

class DeleteTxtRecord extends AbstractCommand
{

    private $domainname;
    private $hostname;

    public function __construct($domainname, $hostname)
    {
        parent::__construct("delete", "/v2/dns/{domainname}/txtrecords/{txtrecord}");

        $this->setDomainname($domainname);
        $this->setHostname($hostname);
    }

    public function prepare()
    {

        $this->setEndPoint("/v2/dns/".$this->domainname."/txtrecords/".$this->hostname);

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
    public function getHostname()
    {
        return $this->hostname;
    }

    /**
     * @param mixed $hostname
     */
    public function setHostname($hostname)
    {
        $this->hostname = $hostname;
    }

}
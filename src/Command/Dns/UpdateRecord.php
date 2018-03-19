<?php

namespace TomCan\CombellApi\Command\Dns;

use TomCan\CombellApi\Command\AbstractCommand;

class UpdateRecord extends AbstractCommand
{

    private $domainname;
    private $record;

    public function __construct($domainname, $record)
    {
        parent::__construct("put", "/v2/dns/{domainname}/records/{recordid}");

        $this->setDomainname($domainname);
        $this->setRecord($record);
    }

    public function prepare()
    {

        $this->setEndPoint("/v2/dns/".$this->domainname."/records/".$this->record->getId());
        $obj = $this->record->getObject();

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
    public function getRecord()
    {
        return $this->record;
    }

    /**
     * @param mixed $record
     */
    public function setRecord($record)
    {
        $this->record = $record;
    }

}
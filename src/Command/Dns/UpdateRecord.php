<?php

namespace TomCan\CombellApi\Command\Dns;

use TomCan\CombellApi\Command\AbstractCommand;

class UpdateRecord extends AbstractCommand
{
    private $domainname;
    private $record;

    public function __construct(string $domainname, string $record)
    {
        parent::__construct('put', '/v2/dns/{domainname}/records/{recordid}');

        $this->setDomainname($domainname);
        $this->setRecord($record);
    }

    public function prepare(): void
    {
        $this->setEndPoint('/v2/dns/' . $this->domainname . '/records/' . $this->record->getId());
        $obj = $this->record->getObject();

        $this->setBody((string) json_encode($obj));
    }

    public function getDomainname(): string
    {
        return $this->domainname;
    }

    public function setDomainname(string $domainname): void
    {
        $this->domainname = $domainname;
    }

    public function getRecord(): string
    {
        return $this->record;
    }

    public function setRecord(string $record): void
    {
        $this->record = $record;
    }
}

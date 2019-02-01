<?php

namespace TomCan\CombellApi\Command\Dns;

use TomCan\CombellApi\Command\AbstractCommand;

class CreateRecord extends AbstractCommand
{
    private $domainname;
    private $record;

    public function __construct(string $domainname, string $record)
    {
        parent::__construct('post', '/v2/dns/{domainname}/records');

        $this->setDomainname($domainname);
        $this->setRecord($record);
    }

    public function prepare(): void
    {
        $this->setEndPoint('/v2/dns/' . $this->domainname . '/records');
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

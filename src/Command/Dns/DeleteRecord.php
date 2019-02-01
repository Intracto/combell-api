<?php

namespace TomCan\CombellApi\Command\Dns;

use TomCan\CombellApi\Command\AbstractCommand;
use TomCan\CombellApi\Structure\Dns\AbstractDnsRecord;

class DeleteRecord extends AbstractCommand
{
    private $domainname;
    private $record;

    public function __construct($domainname, $record)
    {
        parent::__construct('delete', '/v2/dns/{domainname}/records/{recordid}');

        $this->setDomainname($domainname);

        if ($record instanceof AbstractDnsRecord) {
            $this->setRecord($record->getId());
        } else {
            $this->setRecord($record);
        }
    }

    public function prepare(): void
    {
        $this->setEndPoint('/v2/dns/' . $this->domainname . '/records/' . $this->record);
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

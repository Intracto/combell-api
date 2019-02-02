<?php

namespace TomCan\CombellApi\Command\Dns;

use TomCan\CombellApi\Command\AbstractCommand;
use TomCan\CombellApi\Structure\Dns\AbstractDnsRecord;

class DeleteRecord extends AbstractCommand
{
    private $domainName;
    private $record;

    public function __construct(string $domainName, $record)
    {
        parent::__construct('delete', '/v2/dns/{domainname}/records/{recordid}');

        $this->setDomainName($domainName);

        if ($record instanceof AbstractDnsRecord) {
            $this->setRecord($record->getId());
        } else {
            $this->setRecord($record);
        }
    }

    public function prepare(): void
    {
        $this->setEndPoint('/v2/dns/' . $this->domainName . '/records/' . $this->record);
    }

    public function getDomainName(): string
    {
        return $this->domainName;
    }

    public function setDomainName(string $domainName): void
    {
        $this->domainName = $domainName;
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

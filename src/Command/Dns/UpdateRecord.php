<?php

namespace TomCan\CombellApi\Command\Dns;

use TomCan\CombellApi\Command\AbstractCommand;

class UpdateRecord extends AbstractCommand
{
    private $domainName;
    private $record;

    public function __construct(string $domainName, string $record)
    {
        parent::__construct('put', '/v2/dns/{domainname}/records/{recordid}');

        $this->setDomainName($domainName);
        $this->setRecord($record);
    }

    public function prepare(): void
    {
        $this->setEndPoint('/v2/dns/' . $this->domainName . '/records/' . $this->record->getId());
        $obj = $this->record->getObject();

        $this->setBody((string) json_encode($obj));
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

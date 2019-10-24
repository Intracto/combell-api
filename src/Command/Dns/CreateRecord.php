<?php

namespace TomCan\CombellApi\Command\Dns;

use TomCan\CombellApi\Command\AbstractCommand;
use TomCan\CombellApi\Structure\Dns\AbstractDnsRecord;
use TomCan\CombellApi\Structure\Dns\DnsCAARecord;

class CreateRecord extends AbstractCommand
{
    private $domainName;
    /** @var AbstractDnsRecord */
    private $record;

    public function __construct(string $domainName, AbstractDnsRecord $record)
    {
        parent::__construct('post', '/v2/dns/{domainName}/records');

        $this->domainName = $domainName;
        $this->setRecord($record);
    }

    private function setRecord(AbstractDnsRecord $record): void
    {
        if ($record instanceof DnsCAARecord) {
            throw new \InvalidArgumentException('CAA record type is not supported by the API');
        }

        $this->record = $record;
    }

    public function prepare(): void
    {
        $this->setEndPoint('/v2/dns/' . $this->domainName . '/records');
        $obj = $this->record->getObject();

        $this->setBody((string) json_encode($obj));
    }

    public function processResponse(array $response)
    {
        return explode('/', $response['headers']['Location'])[5];
    }
}

<?php

namespace TomCan\CombellApi\Command\Dns;

use TomCan\CombellApi\Command\AbstractCommand;
use TomCan\CombellApi\Structure\Dns\AbstractDnsRecord;

class DeleteRecord extends AbstractCommand
{
    private $domainName;
    private $record;

    public function __construct(string $domainName, AbstractDnsRecord $record)
    {
        parent::__construct('delete', '/v2/dns/{domainName}/records/{recordId}');

        $this->domainName = $domainName;

        $this->record = $record;
    }

    public function prepare(): void
    {
        $this->setEndPoint('/v2/dns/' . $this->domainName . '/records/' . $this->record->getId());
    }

    public function processResponse(array $response)
    {
    }
}

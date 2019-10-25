<?php

namespace TomCan\CombellApi\Command\Dns;

use TomCan\CombellApi\Command\AbstractCommand;
use TomCan\CombellApi\Structure\Dns\AbstractDnsRecord;

class UpdateRecord extends AbstractCommand
{
    private $domainName;
    private $record;

    public function __construct(string $domainName, AbstractDnsRecord $record)
    {
        parent::__construct('put', '/v2/dns/{domainName}/records/{recordId}');

        $this->domainName = $domainName;
        $this->record = $record;
    }

    public function prepare(): void
    {
        $this->setEndPoint('/v2/dns/'.$this->domainName.'/records/'.$this->record->getId());
        $obj = $this->record->getObject();

        $this->setBody((string) json_encode($obj));
    }

    public function processResponse(array $response)
    {
    }
}

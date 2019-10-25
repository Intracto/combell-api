<?php

namespace TomCan\CombellApi\Command\Dns;

use TomCan\CombellApi\Command\AbstractCommand;

class GetRecord extends AbstractCommand
{
    private $domainName;
    private $id;

    public function __construct(string $domainName, string $id)
    {
        parent::__construct('get', '/v2/dns/{domainName}/records/{recordId}');

        $this->domainName = $domainName;
        $this->id = $id;
    }

    public function prepare(): void
    {
        $this->setEndPoint('/v2/dns/' . $this->domainName . '/records/' . $this->id);
    }

    public function processResponse(array $response)
    {
        $record = $response['body'];
        $className = "\\TomCan\\CombellApi\\Structure\\Dns\\Dns" . $record->type . 'Record';

        switch ($record->type) {
            case 'A':
            case 'AAAA':
            case 'NS':
            case 'TXT':
            case 'CNAME':
            case 'SOA':
            case 'CAA':
                $rec = new $className($record->id, $record->record_name, $record->ttl, $record->content);
                break;
            case 'MX':
                $rec = new $className($record->id, $record->record_name, $record->ttl, $record->content, $record->priority);
                break;
            case 'SRV':
                $rec = new $className($record->id, $record->record_name, $record->ttl, $record->service, $record->target, $record->protocol, $record->priority, $record->port, $record->weight);
                break;
            default:
                throw new \LogicException('Unknown DNS record type ' . $record->type);
        }

        return $rec;
    }
}

<?php

namespace TomCan\CombellApi\Command\Dns;

use TomCan\CombellApi\Command\AbstractCommand;

class ListRecords extends AbstractCommand
{
    private $domainname;

    public function __construct($domainname)
    {
        parent::__construct('get', '/v2/dns/{domainname}/records');

        $this->setDomainname($domainname);
    }

    public function prepare(): void
    {
        parent::prepare();

        $this->setEndPoint('/v2/dns/' . $this->domainname . '/records');
    }

    public function getDomainname(): string
    {
        return $this->domainname;
    }

    public function setDomainname(string $domainname): void
    {
        $this->domainname = $domainname;
    }

    public function processResponse($response)
    {
        $records = [];
        foreach ($response['body'] as $record) {
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
            $records[] = $rec;
        }

        $response['response'] = $records;

        return $response;
    }
}

<?php

namespace TomCan\CombellApi\Command\Dns;

use TomCan\CombellApi\Command\PageableAbstractCommand;

class ListRecords extends PageableAbstractCommand
{
    private $domainName;

    public function __construct(string $domainName)
    {
        parent::__construct('get', '/v2/dns/{domainName}/records');

        $this->domainName = $domainName;
    }

    public function prepare(): void
    {
        parent::prepare();

        $this->setEndPoint('/v2/dns/'.$this->domainName.'/records');
    }

    public function processResponse(array $response)
    {
        $records = [];
        foreach ($response['body'] as $record) {
            $className = '\\TomCan\\CombellApi\\Structure\\Dns\\Dns'.$record->type.'Record';
            switch ($record->type) {
                case 'A':
                case 'AAAA':
                case 'NS':
                case 'TXT':
                case 'CNAME':
                case 'SOA':
                case 'CAA':
                case 'ALIAS':
                    $rec = new $className(
                        $record->id,
                        $record->record_name,
                        $record->ttl,
                        $record->content
                    );

                    break;

                case 'MX':
                    $rec = new $className(
                        $record->id,
                        $record->record_name,
                        $record->ttl,
                        $record->content,
                        $record->priority
                    );

                    break;

                case 'SRV':
                    $rec = new $className(
                        $record->id,
                        $record->record_name,
                        $record->ttl,
                        $record->service,
                        $record->target,
                        $record->protocol,
                        $record->priority,
                        $record->port,
                        $record->weight
                    );

                    break;

                default:
                    throw new \LogicException('Unknown DNS record type '.$record->type);
            }
            $records[] = $rec;
        }

        return $records;
    }
}

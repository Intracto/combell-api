<?php

namespace TomCan\CombellApi\Command\Dns;

use TomCan\CombellApi\Command\AbstractCommand;

class GetRecord extends AbstractCommand
{
    private $domainname;
    private $id;

    public function __construct($domainname, $id)
    {
        parent::__construct('get', '/v2/dns/{domainname}/records/{id}');

        $this->setDomainname($domainname);
        $this->setId($id);
    }

    public function prepare(): void 
    {
        $this->setEndPoint('/v2/dns/' . $this->domainname . '/records/' . $this->id);
    }

    public function getDomainname(): string
    {
        return $this->domainname;
    }

    public function setDomainname(string $domainname): void
    {
        $this->domainname = $domainname;
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function setId(string $id): void
    {
        $this->id = $id;
    }

    public function processResponse($response)
    {
        $record = $response['body'];
        $className = "\\TomCan\\CombellApi\\Structure\\Dns\\Dns" . $record->type . 'Record';

        switch ($record->type) {
            case 'A':
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

        $response['response'] = $rec;

        return $response;
    }
}

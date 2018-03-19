<?php

namespace TomCan\CombellApi\Command\Dns;

use TomCan\CombellApi\Command\AbstractCommand;

class ListRecords extends AbstractCommand
{

    private $domainname;

    public function __construct($domainname)
    {
        parent::__construct("get", "/v2/dns/{domainname}/records");
        $this->setDomainname($domainname);
    }

    public function prepare()
    {
        $this->setEndPoint('/v2/dns/'.$this->domainname.'/records');
    }

    /**
     * @return mixed
     */
    public function getDomainname()
    {
        return $this->domainname;
    }

    /**
     * @param mixed $domainname
     */
    public function setDomainname($domainname)
    {
        $this->domainname = $domainname;
    }

    public function processResponse($response)
    {

        $records = array();
        foreach ($response['body'] as $record) {
            var_dump($record);
            $className = "\\TomCan\\CombellApi\\Structure\\Dns\\Dns" . $record->type . "Record";
            switch ($record->type) {
                case "A":
                case "NS":
                case "TXT":
                case "CNAME":
                case "SOA":
                case "CAA":
                    $rec = new $className($record->id, $record->record_name, $record->ttl, $record->content);
                    break;
                case "MX":
                    $rec = new $className($record->id, $record->record_name, $record->ttl, $record->content, $record->priority);
                    break;
                case "SRV":
                    $rec = new $className($record->id, $record->record_name, $record->ttl, $record->service, $record->target, $record->protocol, $record->priority, $record->port, $record->weight);
                    break;
                default:
                    throw new \Exception("Unknown DNS record type " . $record->type);
            }
            $records[] = $rec;
        }

        $response['response'] = $records;
        return $response;

    }

}
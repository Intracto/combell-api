<?php

namespace TomCan\CombellApi\Command\LinuxHostings;

use TomCan\CombellApi\Command\AbstractCommand;

class AddSshKey extends AbstractCommand
{
    private $domainName;
    private $pubKey;

    public function __construct(string $domainName, string $pubKey)
    {
        parent::__construct('post', '/v2/linuxhostings/{domainName}/ssh/keys');

        $this->domainName = $domainName;
        $this->pubKey = $pubKey;
    }

    public function prepare(): void
    {
        $this->setEndPoint('/v2/linuxhostings/'.$this->domainName.'/ssh/keys');

        $obj = new \stdClass();
        $obj->public_key = $this->pubKey;

        $this->setBody((string) json_encode($obj));
    }

    public function processResponse(array $response)
    {
    }
}

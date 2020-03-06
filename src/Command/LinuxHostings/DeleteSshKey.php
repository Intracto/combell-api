<?php

namespace TomCan\CombellApi\Command\LinuxHostings;

use TomCan\CombellApi\Command\AbstractCommand;

class DeleteSshKey extends AbstractCommand
{
    private $domainName;
    private $fingerprint;

    public function __construct(string $domainName, string $fingerprint)
    {
        parent::__construct('delete', '/v2/linuxhostings/{domainName}/ssh/keys/{fingerprint}');

        $this->domainName = $domainName;
        $this->fingerprint = $fingerprint;
    }

    public function prepare(): void
    {
        $this->setEndPoint('/v2/linuxhostings/'.$this->domainName.'/ssh/keys/'.$this->fingerprint);
    }

    public function processResponse(array $response)
    {
    }
}

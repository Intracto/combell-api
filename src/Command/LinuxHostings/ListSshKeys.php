<?php

namespace TomCan\CombellApi\Command\LinuxHostings;

use TomCan\CombellApi\Command\AbstractCommand;
use TomCan\CombellApi\Structure\Ssh\SshKey;

class ListSshKeys extends AbstractCommand
{
    private $domainName;

    public function __construct(string $domainName)
    {
        parent::__construct('get', '/v2/linuxhostings/{domainName}/ssh/keys');

        $this->domainName = $domainName;
    }

    public function prepare(): void
    {
        $this->setEndPoint('/v2/linuxhostings/'.$this->domainName.'/ssh/keys');
    }

    public function processResponse(array $response)
    {
        $sshKeys = [];
        foreach ($response['body'] as $sshKey) {
            $sshKeys[] = new SshKey($sshKey->public_key, $sshKey->fingerprint, []);
        }

        return $sshKeys;
    }
}

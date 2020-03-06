<?php

namespace TomCan\CombellApi\Command\Accounts;

use TomCan\CombellApi\Command\PageableAbstractCommand;
use TomCan\CombellApi\Structure\Ssh\SshKey;

class ListSshKeys extends PageableAbstractCommand
{

    public function __construct()
    {
        parent::__construct('get', '/v2/ssh');
    }

    public function prepare(): void
    {
    }

    public function processResponse(array $response)
    {
        $sshKeys = [];
        foreach ($response['body'] as $sshKey) {
            $sshKeys[] = new SshKey($sshKey->public_key, $sshKey->fingerprint, $sshKey->linux_hostings);
        }

        return $sshKeys;
    }
}

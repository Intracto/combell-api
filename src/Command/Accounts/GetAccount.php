<?php

namespace TomCan\CombellApi\Command\Accounts;

use TomCan\CombellApi\Command\AbstractCommand;
use TomCan\CombellApi\Structure\Accounts\Account;

class GetAccount extends AbstractCommand
{
    private $id;

    public function __construct(int $id)
    {
        parent::__construct('get', '/v2/accounts');

        $this->id = $id;
    }

    public function prepare(): void
    {
        $this->setEndPoint('/v2/accounts/'.$this->id);
    }

    public function processResponse(array $response)
    {
        $account = new Account(
            $response['body']->id,
            $response['body']->identifier,
            $response['body']->servicepack->id
        );
        foreach ($response['body']->addons as $addon) {
            $account->addAddon($addon->id, $addon->name);
        }

        return $account;
    }
}

<?php

namespace TomCan\CombellApi\Command\Accounts;

use TomCan\CombellApi\Command\PageableAbstractCommand;
use TomCan\CombellApi\Structure\Accounts\Account;

class ListAccounts extends PageableAbstractCommand
{
    private $assetType;
    private $identifier;

    public function __construct(string $assetType = '', string $identifier = '')
    {
        parent::__construct('get', '/v2/accounts');
        $this->setAssetType($assetType);
        $this->setIdentifier($identifier);
    }

    public function prepare(): void
    {
        parent::prepare();

        $this->appendQueryString('asset_type', $this->assetType);
        $this->appendQueryString('identifier', $this->identifier);
    }

    public function getAssetType(): string
    {
        return $this->assetType;
    }

    public function setAssetType(string $assetType): void
    {
        if ($assetType === '') {
            $this->assetType = '';

            return;
        }

        if (! \in_array($assetType, ['domain', 'linux_hosting', 'mysql', 'dns', 'mailbox'], true)) {
            throw new \InvalidArgumentException('Invalid asset type specified');
        }

        $this->assetType = $assetType;
    }

    public function getIdentifier(): string
    {
        return $this->identifier;
    }

    public function setIdentifier(string $identifier): void
    {
        $this->identifier = $identifier;
    }

    public function processResponse($response)
    {
        parent::processResponse($response);

        $accounts = [];
        foreach ($response['body'] as $account) {
            $accounts[] = new Account($account->id, $account->identifier);
        }

        return $accounts;
    }
}

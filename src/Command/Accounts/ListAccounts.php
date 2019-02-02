<?php

namespace TomCan\CombellApi\Command\Accounts;

use TomCan\CombellApi\Command\AbstractCommand;
use TomCan\CombellApi\Structure\Accounts\Account;

class ListAccounts extends AbstractCommand
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
        } else {
            if (! \in_array($assetType, ['domain', 'linux_hosting', 'mysql', 'dns', 'mailbox'], true)) {
                throw new \InvalidArgumentException('Invalid asset_type specified');
            }

            $this->assetType = $assetType;
        }
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
        $accounts = [];
        foreach ($response['body'] as $item) {
            $accounts[] = new Account($item->id, $item->identifier);
        }
        $response['response'] = $accounts;

        return $response;
    }
}

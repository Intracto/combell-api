<?php

namespace TomCan\CombellApi\Command\Accounts;

use TomCan\CombellApi\Command\AbstractCommand;
use TomCan\CombellApi\Structure\Accounts\BasicAccount;

class ListAccounts extends AbstractCommand
{

    private $assetType;
    private $identifier;

    public function __construct($assetType = "", $identifier = "")
    {
        parent::__construct("get", "/v2/accounts");
        $this->setAssetType($assetType);
        $this->setIdentifier($identifier);
    }

    public function prepare()
    {
        parent::prepare();

        $this->appendQueryString("asset_type", $this->assetType);
        $this->appendQueryString("identifier", $this->identifier);

    }

    /**
     * @return string
     */
    public function getAssetType()
    {
        return $this->assetType;
    }

    /**
     * @param string $assetType
     */
    public function setAssetType($assetType)
    {

        if ($assetType == "") {
            $this->assetType = "";
        } else {

            if (in_array($assetType, array("domain", "linux_hosting", "mysql", "dns", "mailbox"))) {
                $this->assetType = $assetType;
            } else {
                throw new \InvalidArgumentException("Invalid asset_type specified");
            }

        }

    }

    /**
     * @return mixed
     */
    public function getIdentifier()
    {
        return $this->identifier;
    }

    /**
     * @param mixed $identifier
     */
    public function setIdentifier($identifier)
    {
        $this->identifier = $identifier;
    }

    public function processResponse($response)
    {

        $accounts = array();
        foreach ($response['body'] as $item) {
            $accounts[] = new BasicAccount($item->id, $item->identifier);
        }
        $response['response'] = $accounts;
        return $response;

    }

}
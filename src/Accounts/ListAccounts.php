<?php

namespace TomCan\CombellApi\Accounts;

use TomCan\CombellApi\Common\AbstractCommand;

class ListAccounts extends AbstractCommand
{

    private $assetType;
    private $identifier;

    public function __construct($assetType = "", $identifier = "")
    {
        parent::__construct("get", "/v2/accounts");
        $this->setAssetType($assetType);
        $this->identifier = $identifier;
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

}
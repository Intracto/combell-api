<?php

namespace TomCan\CombellApi\Accounts;

use TomCan\CombellApi\Common\AbstractCommand;

class ListAccounts extends AbstractCommand
{

    private $assetType;

    public function __construct($assetType = "")
    {
        parent::__construct("get", "/v2/accounts");
        $this->setAssetType($assetType);
    }

    public function prepare()
    {
        parent::prepare();

        if ($this->assetType !== "") {
            $qs = "asset_type=" . $this->assetType;
            if ($this->getQueryString() === "") {
                $this->setQueryString($qs);
            } else {
                $this->setQueryString($this->getQueryString() . '&' . $qs);
            }
        }

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
<?php

namespace TomCan\CombellApi\Structure\MysqlDatabases;

class MysqlDatabase
{

    private $accountId;
    private $name;
    private $hostname;
    private $userCount;
    private $maxSize;
    private $actualSize;

    /**
     * MysqlDatabase constructor.
     * @param $accountId
     * @param $name
     * @param $hostname
     * @param $userCount
     * @param $maxSize
     * @param $actualSize
     */
    public function __construct($accountId = "", $name = "", $hostname = "", $userCount = "", $maxSize = "", $actualSize = "")
    {
        $this->accountId = $accountId;
        $this->name = $name;
        $this->hostname = $hostname;
        $this->userCount = $userCount;
        $this->maxSize = $maxSize;
        $this->actualSize = $actualSize;
    }

    /**
     * @return string
     */
    public function getAccountId()
    {
        return $this->accountId;
    }

    /**
     * @param string $accountId
     */
    public function setAccountId(string $accountId)
    {
        $this->accountId = $accountId;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName(string $name)
    {
        $this->name = $name;
    }

    /**
     * @return string
     */
    public function getHostname()
    {
        return $this->hostname;
    }

    /**
     * @return string
     */
    public function getUserCount()
    {
        return $this->userCount;
    }

    /**
     * @return string
     */
    public function getMaxSize()
    {
        return $this->maxSize;
    }

    /**
     * @return string
     */
    public function getActualSize()
    {
        return $this->actualSize;
    }

}
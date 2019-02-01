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

    public function __construct(
        int $accountId = 0,
        string $name = '',
        string $hostname = '',
        int $userCount = 0,
        int $maxSize = 0,
        int $actualSize = 0
    ) {
        $this->accountId = $accountId;
        $this->name = $name;
        $this->hostname = $hostname;
        $this->userCount = $userCount;
        $this->maxSize = $maxSize;
        $this->actualSize = $actualSize;
    }

    public function getAccountId(): string
    {
        return $this->accountId;
    }

    public function setAccountId(string $accountId): void
    {
        $this->accountId = $accountId;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): void
    {
        $this->name = $name;
    }

    public function getHostname(): string
    {
        return $this->hostname;
    }

    public function getUserCount(): string
    {
        return $this->userCount;
    }

    public function getMaxSize(): string
    {
        return $this->maxSize;
    }

    public function getActualSize(): string
    {
        return $this->actualSize;
    }
}

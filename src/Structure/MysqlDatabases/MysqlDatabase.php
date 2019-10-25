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

    public function getAccountId(): int
    {
        return $this->accountId;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getHostname(): string
    {
        return $this->hostname;
    }

    public function getUserCount(): int
    {
        return $this->userCount;
    }

    public function getMaxSize(): int
    {
        return $this->maxSize;
    }

    public function getActualSize(): int
    {
        return $this->actualSize;
    }
}

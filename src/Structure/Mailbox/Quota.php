<?php

namespace TomCan\CombellApi\Structure\Mailbox;

class Quota
{
    private $size;
    private $accountId;

    public function __construct(int $size, int $accountId)
    {
        $this->size = $size;
        $this->accountId = $accountId;
    }

    public function getSize(): int
    {
        return $this->size;
    }

    public function getAccountId(): int
    {
        return $this->accountId;
    }
}

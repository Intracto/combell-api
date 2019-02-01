<?php

namespace TomCan\CombellApi\Structure\Accounts;

class Account
{
    private $id;
    private $identifier;

    public function __construct(int $id = 0, string $identifier = '')
    {
        $this->id = $id;
        $this->identifier = $identifier;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function setId(int $id): void
    {
        $this->id = $id;
    }

    public function getIdentifier(): string
    {
        return $this->identifier;
    }

    public function setIdentifier(string $identifier): void
    {
        $this->identifier = $identifier;
    }
}

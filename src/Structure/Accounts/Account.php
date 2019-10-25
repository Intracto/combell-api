<?php

namespace TomCan\CombellApi\Structure\Accounts;

class Account
{
    private $id;
    private $identifier;
    private $servicepackId;
    private $addons = [];

    public function __construct(int $id, string $identifier, int $servicepackId)
    {
        $this->id = $id;
        $this->identifier = $identifier;
        $this->servicepackId = $servicepackId;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getIdentifier(): string
    {
        return $this->identifier;
    }

    public function getServicepackId(): int
    {
        return $this->servicepackId;
    }

    public function getAddons(): array
    {
        return $this->addons;
    }

    public function addAddon(int $addon): void
    {
        $this->addons[] = $addon;
    }
}

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

    public function getServicepackId(): int
    {
        return $this->servicepackId;
    }

    public function setServicepackId(int $servicepackId): void
    {
        $this->servicepackId = $servicepackId;
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

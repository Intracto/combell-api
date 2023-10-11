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

    public function addAddon(int $id, string $name): void
    {
        // don't use id a key/index, as the same add-on can be applied multiple times to the same account
        $this->addons[] = ['id' => $id, 'name' => $name];
    }
}

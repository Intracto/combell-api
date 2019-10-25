<?php

namespace TomCan\CombellApi\Structure\ProvisioningJobs;

class ResourceLink
{
    private $id;
    private $type;

    public function __construct(string $id, string $type)
    {
        $this->id = $id;
        $this->type = $type;
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function getType(): string
    {
        return $this->type;
    }
}

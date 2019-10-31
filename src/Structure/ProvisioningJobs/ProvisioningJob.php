<?php

namespace TomCan\CombellApi\Structure\ProvisioningJobs;

class ProvisioningJob
{
    private $id;
    private $status;
    private $estimate;
    private $resourceLinks;

    public function __construct(string $id, string $status, ?\DateTime $estimate = null, array $resourceLinks = [])
    {
        $this->id = $id;
        $this->status = $status;
        $this->estimate = $estimate;
        $this->resourceLinks = $resourceLinks;
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function getStatus(): string
    {
        return $this->status;
    }

    public function getEstimate(): ?\DateTime
    {
        return $this->estimate;
    }

    /**
     * @return ResourceLink[]
     */
    public function getResourceLinks(): array
    {
        return $this->resourceLinks;
    }
}

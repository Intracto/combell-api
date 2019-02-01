<?php

namespace TomCan\CombellApi\Structure\ProvisioningJobs;

class ProvisioningJob
{
    private $id;
    private $status;
    private $estimate;
    private $links;

    public function __construct(string $id, string $status, ?\DateTime $estimate = null, array $links = [])
    {
        $this->id = $id;
        $this->status = $status;
        $this->estimate = $estimate;
        $this->links = $links;
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function getStatus(): string
    {
        return $this->status;
    }

    public function setStatus(string $status): void
    {
        $this->status = $status;
    }

    public function getEstimate(): ?\DateTime
    {
        return $this->estimate;
    }

    public function setEstimate(\DateTime $estimate): void
    {
        $this->estimate = $estimate;
    }

    public function getLinks(): array
    {
        return $this->links;
    }

    public function setLinks(array $links): void
    {
        $this->links = $links;
    }
}

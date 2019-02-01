<?php

namespace TomCan\CombellApi\Command\ProvisioningJobs;

use TomCan\CombellApi\Command\AbstractCommand;
use TomCan\CombellApi\Structure\ProvisioningJobs\ProvisioningJob;

class GetProvisioningJob extends AbstractCommand
{
    private $jobId;
    private $status = '';
    private $resource_links = [];

    public function __construct(string $jobId)
    {
        parent::__construct('get', '/v2/provisioningjobs/{jobid}');

        $this->jobId = $jobId;
    }

    public function prepare(): void
    {
        $this->setEndPoint('/v2/provisioningjobs/' . $this->jobId);
    }

    public function processResponse($response)
    {
        $provisioningJob = new ProvisioningJob($this->getJobId(), '');

        if ((int) $response['status'] === 200) {
            $this->status = $response['body']->status;
            $provisioningJob->setStatus($response['body']->status);
        }

        if ((int) $response['status'] === 201) {
            $this->status = 'finished';
            $this->resource_links = [];
            foreach ($response['body']->resource_links as $link) {
                $matches = [];
                if (preg_match('/\/([a-z]+)\/([^\/]+)$/', $link, $matches)) {
                    $this->resource_links[] = [
                        'type' => $matches[1],
                        'id' => $matches[2],
                    ];
                }
            }
            $provisioningJob->setStatus('finished');
            $provisioningJob->setLinks($this->resource_links);
        }

        $response['response'] = $provisioningJob;

        return $response;
    }

    public function getJobId(): string
    {
        return $this->jobId;
    }

    public function setJobId(string $jobId): void
    {
        $this->jobId = $jobId;
    }

    /**
     * @return array
     */
    public function getResourceLinks(): array
    {
        return $this->resource_links;
    }
}

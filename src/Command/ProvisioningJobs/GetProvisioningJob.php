<?php

namespace TomCan\CombellApi\Command\ProvisioningJobs;

use TomCan\CombellApi\Command\AbstractCommand;
use TomCan\CombellApi\Structure\ProvisioningJobs\ProvisioningJob;
use TomCan\CombellApi\Structure\ProvisioningJobs\ResourceLink;

class GetProvisioningJob extends AbstractCommand
{
    private $jobId;

    public function __construct(string $jobId)
    {
        parent::__construct('get', '/v2/provisioningjobs/{jobId}');

        $this->jobId = $jobId;
    }

    public function prepare(): void
    {
        $this->setEndPoint('/v2/provisioningjobs/'.$this->jobId);
    }

    public function processResponse(array $response)
    {
        $status = '';
        $estimate = null;
        $resourceLinks = [];

        if (200 === (int) $response['status']) {
            $status = $response['body']->status;
            $estimate = new \DateTime($response['body']->completion->estimation);
        }

        if (201 === (int) $response['status']) {
            $status = 'finished';
            foreach ($response['body']->resource_links as $link) {
                $linkData = [];
                if (preg_match('/\/([a-z]+)\/([^\/]+)$/', $link, $linkData)) {
                    $resourceLinks[] = new ResourceLink(
                        $linkData[2],
                        $linkData[1]
                    );
                }
            }
        }

        return new ProvisioningJob($this->jobId, $status, $estimate, $resourceLinks);
    }
}

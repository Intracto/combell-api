<?php

namespace TomCan\CombellApi\Command\ProvisioningJobs;

use TomCan\CombellApi\Command\AbstractCommand;
use TomCan\CombellApi\Structure\ProvisioningJobs\ProvisioningJob;

class GetProvisioningJob extends AbstractCommand
{

    private $job_id;

    private $status = '';
    private $resource_links = array();

    public function __construct($job_id)
    {
        parent::__construct("get", "/v2/provisioningjobs/{jobid}");

        $this->job_id = $job_id;

    }

    public function prepare()
    {
        $this->setEndPoint("/v2/provisioningjobs/" . $this->job_id);
    }

    public function processResponse($response)
    {

        $provisioningJob = new ProvisioningJob($this->getJobId(), "");

        if ($response['status'] == 200) {
            $this->status = $response['body']->status;
            $provisioningJob->setStatus($response['body']->status);
        }

        if ($response['status'] == 201) {
            $this->status = 'finished';
            $this->resource_links = array();
            foreach ($response['body']->resource_links as $link) {
                $matches = array();
                if (preg_match('/\/([a-z]+)\/([^\/]+)$/', $link, $matches)) {
                    $this->resource_links[] = array(
                        'type' => $matches[1],
                        'id' => $matches[2],
                    );
                }
            }
            $provisioningJob->setStatus('finished');
            $provisioningJob->setLinks($this->resource_links);
        }

        $response['response'] = $provisioningJob;
        return $response;
    }

    /**
     * @return mixed
     */
    public function getJobId()
    {
        return $this->job_id;
    }

    /**
     * @param mixed $job_id
     */
    public function setJobId($job_id)
    {
        $this->job_id = $job_id;
    }

    /**
     * @return array
     */
    public function getResourceLinks(): array
    {
        return $this->resource_links;
    }

}
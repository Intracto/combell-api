<?php

namespace TomCan\CombellApi\ProvisioningJobs;

use TomCan\CombellApi\Common\AbstractCommand;

class GetProvisioningJob extends AbstractCommand
{

    private $job_id;

    public function __construct($job_id)
    {
        parent::__construct("get", "/v2/provisioningjobs/{jobid}");

        $this->job_id = $job_id;

    }

    public function prepare()
    {
        $this->setEndPoint("/v2/provisioningjobs/" . $this->job_id);
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

}
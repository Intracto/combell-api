<?php

namespace TomCan\CombellApi\Structure\ProvisioningJobs;


class ProvisioningJob
{

    private $id;
    private $status;
    private $estimate;
    private $links;

    /**
     * ProvisioningJob constructor.
     * @param $id
     * @param $status
     * @param $estimate
     * @param $links
     */
    public function __construct($id, $status, $estimate = null, $links = null)
    {
        $this->id = $id;
        $this->status = $status;
        $this->estimate = $estimate;
        $this->links = $links;
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return mixed
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * @param mixed $status
     */
    public function setStatus($status)
    {
        $this->status = $status;
    }

    /**
     * @return mixed
     */
    public function getEstimate()
    {
        return $this->estimate;
    }

    /**
     * @param null $estimate
     */
    public function setEstimate($estimate)
    {
        $this->estimate = $estimate;
    }

    /**
     * @return mixed
     */
    public function getLinks()
    {
        return $this->links;
    }

    /**
     * @param null $links
     */
    public function setLinks($links)
    {
        $this->links = $links;
    }

}
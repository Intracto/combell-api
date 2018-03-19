<?php

namespace TomCan\CombellApi\Command\Accounts;

use TomCan\CombellApi\Command\AbstractCommand;
use TomCan\CombellApi\Structure\ProvisioningJobs\ProvisioningJob;

class CreateAccount extends AbstractCommand
{

    private $identifier;
    private $servicepack;
    private $password;
    private $provisionJob;

    public function __construct($identifier, $servicepack, $password = null)
    {
        parent::__construct("post", "/v2/accounts");

        $this->setIdentifier($identifier);
        $this->setServicepack($servicepack);
        if ($password !== null) $this->setPassword($password);
    }

    public function prepare()
    {

        $obj = new \stdClass();
        $obj->identifier = $this->identifier;

        if (is_object($this->servicepack)) {
            $obj->servicepack_id = $this->servicepack->id;
        } else {
            $obj->servicepack_id = $this->servicepack;
        }

        if ($this->password !== "") {
            $obj->ftp_password = $this->password;
        }

        $this->setBody(
            json_encode($obj)
        );

    }

    public function processResponse($response)
    {

        $id = $response['body']->id;
        $status = isset($response['body']->status) ? $response['body']->status : 'completed';
        $estimate = isset($response['body']->completion->estimate) ? $response['body']->completion->estimate : null;
        $link = null;

        if (isset($response['headers']['Location'])) {
            $h = $response['headers']['Location'][0];
            $link = substr($h, strrpos($h, '/') + 1);
            $this->provisionJob = $link;
        }

        $job = new ProvisioningJob($id, $status, $estimate, $link);
        $response['response'] = $job;

        return $response;
    }

    public function getIdentifier()
    {
        return $this->identifier;
    }

    public function setIdentifier($identifier)
    {
        $this->identifier = $identifier;
    }

    /**
     * @return mixed
     */
    public function getServicepack()
    {
        return $this->servicepack;
    }

    /**
     * @param mixed $servicepack
     */
    public function setServicepack($servicepack)
    {
        $this->servicepack = $servicepack;
    }

    /**
     * @return mixed
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * @param mixed $password
     */
    public function setPassword($password)
    {

        $uppers  = strlen(preg_replace('/[^A-Z]/', '', $password));
        $lowers  = strlen(preg_replace('/[^a-z]/', '', $password));
        $numbers = strlen(preg_replace('/[^0-9]/', '', $password));
        $others  = strlen(preg_replace('/[a-zA-Z0-9]/', '', $password));

        if ($others > 0) {
            throw new \InvalidArgumentException("Password can't contain special characters");
        }

        if (strlen($password) < 8 || strlen($password > 20)) {
            throw  new \InvalidArgumentException("Password must be between 8-20 characters long");
        }

        if (($uppers + $lowers) == 0 || $numbers == 0) {
            throw new \InvalidArgumentException("Password must be a mix of letters and digits");
        }

        $this->password = $password;

    }

    /**
     * @return mixed
     */
    public function getProvisionJob()
    {
        return $this->provisionJob;
    }

}
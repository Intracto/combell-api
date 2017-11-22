<?php

namespace TomCan\CombellApi\Accounts;

use TomCan\CombellApi\Common\AbstractCommand;

class CreateAccount extends AbstractCommand
{

    private $identifier;
    private $servicepack;

    public function __construct($identifier, $servicepack)
    {
        parent::__construct("post", "/v2/accounts");

        $this->setIdentifier($identifier);
        $this->setServicepack($servicepack);
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

        $this->setBody(
            json_encode($obj)
        );

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



}
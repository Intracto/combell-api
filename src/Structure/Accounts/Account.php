<?php

namespace TomCan\CombellApi\Structure\Accounts;

class Account
{

    /**
     * @var int
     */
    private $id;
    /**
     * @var string
     */
    private $identifier;
    /**
     * @var int
     */
    private $servicepack_id;

    /**
     * SimpleAccount constructor.
     * @param int $id
     * @param string $identifier
     * @param int $servicepack_id
     */
    public function __construct($id = 0, $identifier = "", $servicepack_id = 0)
    {
        $this->id = $id;
        $this->identifier = $identifier;
        $this->servicepack_id = $servicepack_id;
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param int $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return string
     */
    public function getIdentifier()
    {
        return $this->identifier;
    }

    /**
     * @param string $identifier
     */
    public function setIdentifier($identifier)
    {
        $this->identifier = $identifier;
    }

    /**
     * @return int
     */
    public function getServicepackId()
    {
        return $this->servicepack_id;
    }

    /**
     * @param int $servicepack_id
     */
    public function setServicepackId($servicepack_id)
    {
        $this->servicepack_id = $servicepack_id;
    }

}

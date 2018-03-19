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
     * SimpleAccount constructor.
     * @param int $id
     * @param string $identifier
     */
    public function __construct($id = 0, $identifier = "")
    {
        $this->id = $id;
        $this->identifier = $identifier;
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @param int $id
     */
    public function setId(int $id)
    {
        $this->id = $id;
    }

    /**
     * @return string
     */
    public function getIdentifier(): string
    {
        return $this->identifier;
    }

    /**
     * @param string $identifier
     */
    public function setIdentifier(string $identifier)
    {
        $this->identifier = $identifier;
    }

}
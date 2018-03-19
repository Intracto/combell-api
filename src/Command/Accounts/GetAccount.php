<?php

namespace TomCan\CombellApi\Command\Accounts;

use TomCan\CombellApi\Command\AbstractCommand;

class GetAccount extends AbstractCommand
{

    /**
     * @var int
     */
    private $id;

    public function __construct($id)
    {
        parent::__construct("get", "/v2/accounts");

        $this->id = $id;

    }

    public function prepare()
    {
        $this->setEndPoint("/v2/accounts/" . $this->id);
    }

}
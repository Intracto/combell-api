<?php

namespace TomCan\CombellApi\Accounts;

use TomCan\CombellApi\Common\AbstractCommand;

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
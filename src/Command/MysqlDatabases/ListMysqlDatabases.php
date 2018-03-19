<?php

namespace TomCan\CombellApi\Command\MysqlDatabases;

use TomCan\CombellApi\Command\AbstractCommand;

class ListMysqlDatabases extends AbstractCommand
{

    public function __construct()
    {
        parent::__construct("get", "/v2/mysqldatabases");
    }

}
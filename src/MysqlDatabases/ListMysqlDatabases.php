<?php

namespace TomCan\CombellApi\MysqlDatabases;

use TomCan\CombellApi\Common\AbstractCommand;

class ListMysqlDatabases extends AbstractCommand
{

    public function __construct()
    {
        parent::__construct("get", "/v2/mysqldatabases");
    }

}
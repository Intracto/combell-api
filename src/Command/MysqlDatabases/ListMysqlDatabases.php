<?php

namespace TomCan\CombellApi\Command\MysqlDatabases;

use TomCan\CombellApi\Command\PageableAbstractCommand;
use TomCan\CombellApi\Structure\MysqlDatabases\MysqlDatabase;

class ListMysqlDatabases extends PageableAbstractCommand
{
    public function __construct()
    {
        parent::__construct('get', '/v2/mysqldatabases');
    }

    public function processResponse(array $response)
    {
        $databases = [];
        foreach ($response['body'] as $db) {
            $databases[] = new MysqlDatabase(
                $db->account_id,
                $db->name,
                $db->hostname,
                $db->user_count,
                $db->max_size,
                $db->actual_size
            );
        }

        return $databases;
    }
}

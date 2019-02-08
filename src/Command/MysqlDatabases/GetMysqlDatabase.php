<?php

namespace TomCan\CombellApi\Command\MysqlDatabases;

use TomCan\CombellApi\Command\AbstractCommand;
use TomCan\CombellApi\Structure\MysqlDatabases\MysqlDatabase;

class GetMysqlDatabase extends AbstractCommand
{
    private $databaseName;

    public function __construct(string $databaseName)
    {
        parent::__construct('get', '/v2/mysqldatabases');

        $this->databaseName = $databaseName;
    }

    public function prepare(): void
    {
        $this->setEndPoint('/v2/mysqldatabases/' . $this->databaseName);
    }

    public function processResponse(array $response)
    {
        $db = $response['body'];

        return new MysqlDatabase(
            $db->account_id,
            $db->name,
            $db->hostname,
            $db->user_count,
            $db->max_size,
            $db->actual_size
        );
    }
}

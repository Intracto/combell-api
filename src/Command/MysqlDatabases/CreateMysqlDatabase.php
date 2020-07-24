<?php

namespace TomCan\CombellApi\Command\MysqlDatabases;

use TomCan\CombellApi\Command\AbstractCommand;

class CreateMysqlDatabase extends AbstractCommand
{
    private $database;
    private $account;
    private $password;

    public function __construct(string $database, int $account, string $password)
    {
        parent::__construct('post', '/v2/mysqldatabases');

        $this->database = $database;
        $this->account = $account;
        $this->password = $password;
    }

    public function prepare(): void
    {
        $obj = [
            'database_name' => $this->database,
            'account_id' => $this->account,
            'password' => $this->password,
        ];

        $this->setBody((string) json_encode($obj));
    }

    public function processResponse(array $response)
    {
        if (isset($response['headers']['Location'])) {
            return explode('/', $response['headers']['Location'][0])[3];
        }

        return explode('/', $response['headers']['location'][0])[3];
    }
}

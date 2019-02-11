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

        $this->setDatabase($database);
        $this->setAccount($account);
        $this->setPassword($password);
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
        return explode('/', $response['headers']['Location'])[3];
    }

    private function setDatabase(string $database): void
    {
        $this->database = $database;
    }

    private function setAccount(int $account): void
    {
        $this->account = $account;
    }

    private function setPassword(string $password): void
    {
        $this->password = $password;
    }
}

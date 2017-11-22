<?php

namespace TomCan\CombellApi\MysqlDatabases;

use TomCan\CombellApi\Common\AbstractCommand;

class CreateMysqlDatabase extends AbstractCommand
{

    private $database;
    private $account;
    private $password;

    public function __construct($database, $account, $password)
    {
        parent::__construct("post", "/v2/mysqldatabases");

        $this->setDatabase($database);
        $this->setAccount($account);
        $this->setPassword($password);
    }

    public function prepare()
    {

        $obj = new \stdClass();
        $obj->database_name = $this->database;
        $obj->account_id = $this->account;
        $obj->password = $this->password;

        $this->setBody(
            json_encode($obj)
        );

    }

    /**
     * @return mixed
     */
    public function getDatabase()
    {
        return $this->database;
    }

    /**
     * @param mixed $database
     */
    public function setDatabase($database)
    {
        $this->database = $database;
    }

    /**
     * @return mixed
     */
    public function getAccount()
    {
        return $this->account;
    }

    /**
     * @param mixed $account
     */
    public function setAccount($account)
    {
        $this->account = $account;
    }

    /**
     * @return mixed
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * @param mixed $password
     */
    public function setPassword($password)
    {
        $this->password = $password;
    }

}
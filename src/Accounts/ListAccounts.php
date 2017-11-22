<?php
/**
 * Created by PhpStorm.
 * User: Tom
 * Date: 21/11/2017
 * Time: 23:55
 */

namespace TomCan\CombellApi\Accounts;


use TomCan\CombellApi\Common\AbstractCommand;

class ListAccounts extends AbstractCommand
{

    public function __construct()
    {
        parent::__construct("get", "/v2/accounts");
    }

}
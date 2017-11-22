<?php
/**
 * Created by PhpStorm.
 * User: tom.cannaerts
 * Date: 22/11/2017
 * Time: 11:08
 */

namespace TomCan\CombellApi\Exception;


class ClientException extends \Exception
{

    private $body;

    /**
     * @return mixed
     */
    public function getBody()
    {
        return $this->body;
    }

    /**
     * @param mixed $body
     */
    public function setBody($body)
    {
        $this->body = $body;
    }

}
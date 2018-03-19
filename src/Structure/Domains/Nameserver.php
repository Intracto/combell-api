<?php
/**
 * Created by PhpStorm.
 * User: Tom
 * Date: 20/03/2018
 * Time: 0:27
 */

namespace TomCan\CombellApi\Structure\Domains;


class Nameserver
{

    private $name;
    private $ip;

    /**
     * Nameserver constructor.
     * @param $name
     * @param $ip
     */
    public function __construct($name, $ip = null)
    {
        $this->name = $name;
        $this->ip = $ip;
    }

    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param mixed $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * @return null
     */
    public function getIp()
    {
        return $this->ip;
    }

    /**
     * @param null $ip
     */
    public function setIp($ip)
    {
        $this->ip = $ip;
    }

}
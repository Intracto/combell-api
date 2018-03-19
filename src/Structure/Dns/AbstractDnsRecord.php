<?php
/**
 * Created by PhpStorm.
 * User: Tom
 * Date: 19/03/2018
 * Time: 22:09
 */

namespace TomCan\CombellApi\Structure\Dns;


class AbstractDnsRecord
{

    protected $id;
    protected $type;
    protected $hostname;

    /**
     * AbstractDnsRecord constructor.
     * @param $id
     * @param $type
     * @param $hostname
     */
    public function __construct($id, $type, $hostname)
    {
        $this->id = $id;
        $this->type = $type;
        $this->hostname = $hostname;
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return mixed
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * @param mixed $type
     */
    public function setType($type)
    {
        $this->type = $type;
    }

    /**
     * @return mixed
     */
    public function getHostname()
    {
        return $this->hostname;
    }

    /**
     * @param mixed $hostname
     */
    public function setHostname($hostname)
    {
        $this->hostname = $hostname;
    }

}
<?php
/**
 * Created by PhpStorm.
 * User: Tom
 * Date: 21/11/2017
 * Time: 22:52
 */

namespace TomCan\CombellApi\Common;


class AbstractCommand
{

    /**
     * @var string
     */
    private $method;

    /**
     * @var string
     */
    private $endPoint;

    /**
     * @var string
     */
    private $queryString = "";

    /**
     * @var string
     */
    private $body = "";

    /**
     * @var int
     */
    private $skip = 0;

    /**
     * @var int
     */
    private $take = 25;


    /**
     * AbstractCommand constructor.
     * @param $method
     * @param $endPoint
     */

    public function __construct($method, $endPoint)
    {
        $this->setEndPoint($endPoint);
        $this->setMethod($method);
    }

    public function prepare() {
        // construct body and querystring
        $this->queryString = "skip=" . $this->skip . "&take=" . $this->take;
    }

    /**
     * @return string
     */
    public function getMethod(): string
    {
        return $this->method;
    }

    /**
     * @param string $method
     */
    public function setMethod(string $method)
    {
        $this->method = $method;
    }

    /**
     * @return string
     */
    public function getEndPoint(): string
    {
        return $this->endPoint;
    }

    /**
     * @param string $endPoint
     */
    public function setEndPoint(string $endPoint)
    {
        $this->endPoint = $endPoint;
    }

    /**
     * @return mixed
     */
    public function getQueryString()
    {
        return $this->queryString;
    }

    /**
     * @param mixed $queryString
     */
    public function setQueryString($queryString)
    {
        $this->queryString = $queryString;
    }

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

    /**
     * @return int
     */
    public function getSkip(): int
    {
        return $this->skip;
    }

    /**
     * @param int $skip
     */
    public function setSkip(int $skip)
    {
        $this->skip = $skip;
    }

    /**
     * @return int
     */
    public function getTake(): int
    {
        return $this->take;
    }

    /**
     * @param int $take
     */
    public function setTake(int $take)
    {
        $this->take = $take;
    }

}
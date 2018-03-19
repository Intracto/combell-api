<?php

namespace TomCan\CombellApi\Command;

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

    public function processResponse($response) {
        // do any post-processing on the response
        return $response;
    }

    /**
     * @return string
     */
    public function getMethod()
    {
        return $this->method;
    }

    /**
     * @param string $method
     */
    public function setMethod($method)
    {
        $this->method = $method;
    }

    /**
     * @return string
     */
    public function getEndPoint()
    {
        return $this->endPoint;
    }

    /**
     * @param string $endPoint
     */
    public function setEndPoint($endPoint)
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

    public function appendQueryString($key, $value, $blank = false) {

        if ($blank || (!$blank && $value != "")) {
            if ($this->queryString != "") {
                $this->queryString .= "&" . $key . "=" . urlencode($value);
            } else {
                $this->queryString = $key . "=" . urlencode($value);
            }
        }

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
    public function getSkip()
    {
        return $this->skip;
    }

    /**
     * @param int $skip
     */
    public function setSkip($skip)
    {
        $this->skip = $skip;
    }

    /**
     * @return int
     */
    public function getTake()
    {
        return $this->take;
    }

    /**
     * @param int $take
     */
    public function setTake($take)
    {
        $this->take = $take;
    }

}
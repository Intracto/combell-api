<?php

namespace TomCan\CombellApi\Command;

abstract class AbstractCommand
{
    private $method;
    private $endPoint;
    private $queryString = '';
    private $body = '';
    private $skip = 0;
    private $take = 25;

    public function __construct(string $method, string $endPoint)
    {
        $this->setEndPoint($endPoint);
        $this->setMethod($method);
    }

    // Construct body and querystring
    public function prepare(): void
    {
        $this->queryString = 'skip=' . $this->skip . '&take=' . $this->take;
    }

    // Do any post-processing on the response, convert to objects
    abstract public function processResponse(array $response);

    public function processHeaders(array $headers): void
    {}

    public function getMethod(): string
    {
        return $this->method;
    }

    public function setMethod(string $method): void
    {
        $this->method = $method;
    }

    public function getEndPoint(): string
    {
        return $this->endPoint;
    }

    public function setEndPoint(string $endPoint): void
    {
        $this->endPoint = $endPoint;
    }

    public function getQueryString(): string
    {
        return $this->queryString;
    }

    public function setQueryString(string $queryString): void
    {
        $this->queryString = $queryString;
    }

    public function appendQueryString($key, $value, $blank = false): void
    {
        if ($blank || (!$blank && $value !== '')) {
            if ($this->queryString !== '') {
                $this->queryString .= '&' . $key . '=' . urlencode($value);
            } else {
                $this->queryString = $key . '=' . urlencode($value);
            }
        }
    }

    public function getBody(): string
    {
        return $this->body;
    }

    public function setBody(string $body): void
    {
        $this->body = $body;
    }

    public function getSkip(): int
    {
        return $this->skip;
    }

    public function setSkip(int $skip): void
    {
        $this->skip = $skip;
    }

    public function getTake(): int
    {
        return $this->take;
    }

    public function setTake(int $take): void
    {
        $this->take = $take;
    }
}

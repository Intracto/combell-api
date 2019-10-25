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
        $this->method = $method;
    }

    // Construct body and querystring
    public function prepare(): void
    {
        $this->queryString = 'skip='.$this->skip.'&take='.$this->take;
    }

    // Do any post-processing on the response, convert to objects
    abstract public function processResponse(array $response);

    public function processHeaders(array $headers): void
    {
    }

    public function getMethod(): string
    {
        return $this->method;
    }

    public function getEndPoint(): string
    {
        return $this->endPoint;
    }

    protected function setEndPoint(string $endPoint): void
    {
        $this->endPoint = $endPoint;
    }

    public function getQueryString(): string
    {
        return $this->queryString;
    }

    public function appendQueryString(string $key, string $value): void
    {
        if (empty($value)) {
            return;
        }

        if ('' !== $this->queryString) {
            $this->queryString .= '&';
        }

        $this->queryString .= $key.'='.urlencode($value);
    }

    public function getBody(): string
    {
        return $this->body;
    }

    public function setBody(string $body): void
    {
        $this->body = $body;
    }

    public function setSkip(int $skip): void
    {
        $this->skip = $skip;
    }

    public function setTake(int $take): void
    {
        $this->take = $take;
    }
}

<?php

namespace TomCan\CombellApi\Exception;

class ClientException extends \Exception
{
    private $body;

    public function getBody(): string
    {
        return $this->body;
    }

    public function setBody(string $body): void
    {
        $this->body = $body;
    }
}

<?php

namespace TomCan\CombellApi\Common;

use TomCan\CombellApi\Adapter\AdapterInterface;
use TomCan\CombellApi\Command\AbstractCommand;

class Api
{
    private $adapter;
    private $hmacGenerator;

    private $responseCode = 0;
    private $rateLimitLimit = 100;
    private $rateLimitUsage = 0;
    private $rateLimitRemaining = 100;
    private $rateLimitReset = 60;

    public function __construct(AdapterInterface $adapter, HmacGenerator $hmacGenerator)
    {
        $this->adapter = $adapter;
        $this->hmacGenerator = $hmacGenerator;
    }

    public function executeCommand(AbstractCommand $command)
    {
        $command->prepare();

        $headers = [
            'Authorization' => $this->hmacGenerator->getHeader($command),
            'Accept' => 'application/json',
            'Content-type' => 'application/json',
        ];

        $ret = $this->adapter->call(
            strtoupper($command->getMethod()),
            'https://api.combell.com' . $command->getEndPoint() . ($command->getQueryString() !== '' ? '?' . $command->getQueryString() : ''),
            $headers,
            $command->getBody()
        );

        $this->responseCode = (int) $ret['status'];
        $this->rateLimitLimit = (int) current($ret['headers']['X-RateLimit-Limit']);
        $this->rateLimitUsage = (int) current($ret['headers']['X-RateLimit-Usage']);
        $this->rateLimitRemaining = (int) current($ret['headers']['X-RateLimit-Remaining']);
        $this->rateLimitReset = (int) current($ret['headers']['X-RateLimit-Reset']);

        if ($ret['body'] !== '') {
            $ret['body'] = \json_decode($ret['body']);
        }

        $command->processHeaders($ret['headers']);

        return $command->processResponse($ret);
    }

    public function getResponseCode(): int
    {
        return $this->responseCode;
    }

    public function getRateLimitLimit(): int
    {
        return $this->rateLimitLimit;
    }

    public function getRateLimitUsage(): int
    {
        return $this->rateLimitUsage;
    }

    public function getRateLimitRemaining(): int
    {
        return $this->rateLimitRemaining;
    }

    public function getRateLimitReset(): int
    {
        return $this->rateLimitReset;
    }
}

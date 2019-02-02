<?php

namespace TomCan\CombellApi\Common;

use TomCan\CombellApi\Adapter\AdapterInterface;
use TomCan\CombellApi\Command\AbstractCommand;

class Api
{
    private $apiKey;
    private $apiSecret;
    private $adapter;

    private $responseCode = 0;
    private $rateLimitLimit = 100;
    private $rateLimitUsage = 0;
    private $rateLimitRemaining = 100;
    private $rateLimitReset = 60;

    public function __construct(string $apiKey, string $apiSecret, AdapterInterface $adapter)
    {
        $this->apiKey = $apiKey;
        $this->apiSecret = $apiSecret;
        $this->adapter = $adapter;
    }

    public function executeCommand(AbstractCommand $command)
    {
        $command->prepare();

        $headers = [
            'Authorization' => $this->getHmacHeader($command),
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

        return $command->processResponse($ret);
    }

    private function getHmacHeader(AbstractCommand $command): string
    {
        $timestamp = time();
        $nonce = uniqid('combell_api', true);
        $input = $this->apiKey .
            strtolower($command->getMethod()) .
            urlencode($command->getEndPoint() . ($command->getQueryString() !== '' ? '?' . $command->getQueryString() : '')) .
            $timestamp .
            $nonce .
            ($command->getBody() !== '' ? base64_encode(md5($command->getBody(), true)) : '');
        $hmac = base64_encode(hash_hmac('sha256', $input, $this->apiSecret, true));

        return 'hmac ' . $this->apiKey . ':' . $hmac . ':' . $nonce . ':' . $timestamp;
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

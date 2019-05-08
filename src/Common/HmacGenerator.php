<?php

namespace TomCan\CombellApi\Common;

use TomCan\CombellApi\Adapter\AdapterInterface;
use TomCan\CombellApi\Command\AbstractCommand;

class HmacGenerator
{
    private $apiKey;
    private $apiSecret;

    public function __construct(string $apiKey, string $apiSecret)
    {
        $this->apiKey = $apiKey;
        $this->apiSecret = $apiSecret;
    }

    public function getHeader(AbstractCommand $command): string
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
}

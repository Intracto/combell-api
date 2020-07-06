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

        if (getenv('DEBUG_DUMPS', true)) {
            // @codeCoverageIgnoreStart
            var_dump(
                strtoupper($command->getMethod()),
                'https://api.combell.com'.$command->getEndPoint().('' !== $command->getQueryString() ? '?'.$command->getQueryString() : ''),
                $headers,
                $command->getBody()
            );
            // @codeCoverageIgnoreEnd
        }

        $ret = $this->adapter->call(
            strtoupper($command->getMethod()),
            'https://api.combell.com'.$command->getEndPoint().('' !== $command->getQueryString() ? '?'.$command->getQueryString() : ''),
            $headers,
            $command->getBody()
        );

        if (getenv('DEBUG_DUMPS', true)) {
            // @codeCoverageIgnoreStart
            var_dump($ret);
            // @codeCoverageIgnoreEnd
        }

        // headers are no longer mixed case, but lower case. Force lower case
        foreach ($ret['headers'] as $key => $value) {
            if ($key != strtolower($key)) {
                $ret[strtolower($key)] = $value;
            }
        }

        $this->responseCode = (int) $ret['status'];
        $this->rateLimitLimit = (int) current($ret['headers']['x-ratelimit-limit']);
        $this->rateLimitUsage = (int) current($ret['headers']['x-ratelimit-usage']);
        $this->rateLimitRemaining = (int) current($ret['headers']['x-ratelimit-remaining']);
        $this->rateLimitReset = (int) current($ret['headers']['x-ratelimit-reset']);

        if ('' !== $ret['body']) {
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

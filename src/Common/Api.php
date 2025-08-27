<?php

namespace TomCan\CombellApi\Common;

use Psr\Log\LoggerInterface;
use Psr\Log\LogLevel;
use TomCan\CombellApi\Adapter\AdapterInterface;
use TomCan\CombellApi\Command\AbstractCommand;

class Api
{
    private $adapter;
    private $hmacGenerator;
    private $logger;

    private $responseCode = 0;
    private $rateLimitLimit = 100;
    private $rateLimitUsage = 0;
    private $rateLimitRemaining = 100;
    private $rateLimitReset = 60;

    public function __construct(AdapterInterface $adapter, HmacGenerator $hmacGenerator, ?LoggerInterface $logger = null)
    {
        $this->adapter = $adapter;
        $this->hmacGenerator = $hmacGenerator;
        $this->logger = $logger;
    }

    private function log(string $level, string $message, array $context = [])
    {
        if ($this->logger !== null) {
            $this->logger->log($level, $message, $context);
        }
    }

    public function executeCommand(AbstractCommand $command)
    {
        $this->log(LogLevel::INFO, 'Executing {command}', ['command' => get_class($command)]);
        $command->prepare();

        $headers = [
            'Authorization' => $this->hmacGenerator->getHeader($command),
            'Accept' => 'application/json',
            'Content-type' => 'application/json',
        ];

        $this->log(LogLevel::INFO,'{method} {endpoint}', ['method' => strtoupper($command->getMethod()), 'endpoint' => $command->getEndPoint().('' !== $command->getQueryString() ? '?'.$command->getQueryString() : '')]);
        $this->log(LogLevel::DEBUG,"Headers:\n{headers}\nBody:\n{body}",
            [
                'headers' => print_r($headers, true),
                'body' => $command->getBody()
            ]
        );

        $ret = $this->adapter->call(
            strtoupper($command->getMethod()),
            'https://api.combell.com'.$command->getEndPoint().('' !== $command->getQueryString() ? '?'.$command->getQueryString() : ''),
            $headers,
            $command->getBody()
        );

        $this->log(LogLevel::DEBUG,"Response:\n{response}", ['response' => print_r($ret, true)]);

        // headers are no longer mixed case, but lower case. Force lower case
        foreach ($ret['headers'] as $key => $value) {
            if ($key != strtolower($key)) {
                $ret[strtolower($key)] = $value;
            }
        }

        $this->responseCode = (int) $ret['status'];
        $this->rateLimitLimit = (int) current((array) $ret['headers']['x-ratelimit-limit']);
        $this->rateLimitUsage = (int) current((array) $ret['headers']['x-ratelimit-usage']);
        $this->rateLimitRemaining = (int) current((array) $ret['headers']['x-ratelimit-remaining']);
        $this->rateLimitReset = (int) current((array) $ret['headers']['x-ratelimit-reset']);

        $this->log(LogLevel::INFO, 'Response code {code}', ['code' => $this->responseCode]);

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

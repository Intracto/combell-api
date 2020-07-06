<?php

namespace Test\Command\Common;

use PHPUnit\Framework\TestCase;
use TomCan\CombellApi\Adapter\AdapterInterface;
use TomCan\CombellApi\Common\HmacGenerator;
use TomCan\CombellApi\Common\Api;
use TomCan\CombellApi\Command\Accounts\ListAccounts;

final class ApiTest extends TestCase
{
    public function testRateLimit(): void
    {
        $returnValue = [
            'status' => 200,
            'headers' => [
                'Transfer-Encoding' => ['chunked'],
                'Content-Type' => ['application/json; charset=utf-8'],
                'x-ratelimit-limit' => ['100'],
                'x-ratelimit-usage' => ['1'],
                'x-ratelimit-remaining' => ['99'],
                'x-ratelimit-reset' => ['60'],
                'x-paging-skipped' => ['0'],
                'x-paging-take' => ['25'],
                'x-paging-totalresults' => ['12345'],
                'Date' => ['Sat, 02 Feb 2019 20:23:35 GMT'],
            ],
            'body' => json_encode([/* not testing this */]),
        ];

        $adapterStub = $this->createMock(AdapterInterface::class);
        $headers = [
            'Authorization' => 'hmac mocked',
            'Accept' => 'application/json',
            'Content-type' => 'application/json',
        ];
        $adapterStub->method('call')
            ->with('GET', 'https://api.combell.com/v2/accounts?skip=0&take=25', $headers, '')
            ->willReturn($returnValue);

        $hmacGeneratorStub = $this->createMock(HmacGenerator::class);
        $hmacGeneratorStub->method('getHeader')
            ->willReturn('hmac mocked');
        $api = new Api($adapterStub, $hmacGeneratorStub);

        $this->assertEquals(0, $api->getResponseCode());

        $this->assertEquals(100, $api->getRateLimitLimit());
        $this->assertEquals(0, $api->getRateLimitUsage());
        $this->assertEquals(100, $api->getRateLimitRemaining());
        $this->assertEquals(60, $api->getRateLimitReset());

        $cmd = new ListAccounts();
        $api->executeCommand($cmd);

        $this->assertEquals(200, $api->getResponseCode());

        $this->assertEquals(100, $api->getRateLimitLimit());
        $this->assertEquals(1, $api->getRateLimitUsage());
        $this->assertEquals(99, $api->getRateLimitRemaining());
        $this->assertEquals(60, $api->getRateLimitReset());
    }
}

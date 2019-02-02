<?php

use PHPUnit\Framework\TestCase;

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
                'X-RateLimit-Limit' => ['100'],
                'X-RateLimit-Usage' => ['1'],
                'X-RateLimit-Remaining' => ['99'],
                'X-RateLimit-Reset' => ['60'],
                'X-Paging-Skipped' => ['0'],
                'X-Paging-Take' => ['25'],
                'X-Paging-TotalResults' => ['12345'],
                'Date' => ['Sat, 02 Feb 2019 20:23:35 GMT'],
            ],
            'body' => json_encode([ /* not testing this */ ])
        ];

        $stub = $this->createMock(\TomCan\CombellApi\Adapter\AdapterInterface::class);
        $stub->method('call')->willReturn($returnValue);

        $api = new Api('', '', $stub);

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

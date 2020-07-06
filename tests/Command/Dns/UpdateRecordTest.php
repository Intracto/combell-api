<?php

namespace Test\Command\Dns;

use PHPUnit\Framework\TestCase;
use TomCan\CombellApi\Adapter\AdapterInterface;
use TomCan\CombellApi\Common\HmacGenerator;
use TomCan\CombellApi\Common\Api;
use TomCan\CombellApi\Command\Dns\UpdateRecord;
use TomCan\CombellApi\Structure\Dns\DnsARecord;

final class UpdateRecordTest extends TestCase
{
    public function testUpdateRecord(): void
    {
        $returnValue = [
            'status' => 200,
            'headers' => [
                'Transfer-Encoding' => ['chunked'],
                'x-ratelimit-limit' => ['100'],
                'x-ratelimit-usage' => ['1'],
                'x-ratelimit-remaining' => ['99'],
                'x-ratelimit-reset' => ['60'],
                'Date' => ['Sat, 02 Feb 2019 20:23:35 GMT'],
            ],
            'body' => '',
        ];

        $adapterStub = $this->createMock(AdapterInterface::class);
        $headers = [
            'Authorization' => 'hmac mocked',
            'Accept' => 'application/json',
            'Content-type' => 'application/json',
        ];
        $adapterStub->method('call')
            ->with('PUT', 'https://api.combell.com/v2/dns/example.com/records/1-1122334455', $headers, '{"id":"1-1122334455","record_name":"","type":"A","ttl":3600,"content":"127.0.0.2"}')
            ->willReturn($returnValue);

        $hmacGeneratorStub = $this->createMock(HmacGenerator::class);
        $hmacGeneratorStub->method('getHeader')
            ->willReturn('hmac mocked');
        $api = new Api($adapterStub, $hmacGeneratorStub);

        $cmd = new UpdateRecord(
            'example.com',
            new DnsARecord(
                '1-1122334455',
                '',
                3600,
                '127.0.0.2'
            )
        );

        $response = $api->executeCommand($cmd);
        $this->assertNull($response);

        $this->assertEquals('200', $api->getResponseCode());
    }
}

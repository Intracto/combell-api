<?php

namespace Test\Command\Dns;

use PHPUnit\Framework\TestCase;

use TomCan\CombellApi\Adapter\AdapterInterface;
use TomCan\CombellApi\Common\HmacGenerator;
use TomCan\CombellApi\Common\Api;

use TomCan\CombellApi\Command\Dns\CreateRecord;
use TomCan\CombellApi\Structure\Dns\DnsARecord;
use TomCan\CombellApi\Structure\Dns\DnsCAARecord;

final class CreateRecordTest extends TestCase
{
    public function testCreateARecord(): void
    {
        $returnValue = [
            'status' => 201,
            'headers' => [
                'Content-Length' => ['0'],
                'Location' => '/v2/dns/example.com/records/1-9988776610',
                'X-RateLimit-Limit' => ['100'],
                'X-RateLimit-Usage' => ['1'],
                'X-RateLimit-Remaining' => ['99'],
                'X-RateLimit-Reset' => ['60'],
                'Date' => ['Sat, 02 Feb 2019 20:23:35 GMT'],
            ],
            'body' => ''
        ];

        $adapterStub = $this->createMock(AdapterInterface::class);
        $headers = [
            'Authorization' => 'hmac mocked',
            'Accept' => 'application/json',
            'Content-type' => 'application/json',
        ];
        $adapterStub->method('call')
            ->with('POST', 'https://api.combell.com/v2/dns/example.com/records', $headers, '{"id":"","record_name":"blog","type":"A","ttl":3600,"content":"127.0.0.1"}')
            ->willReturn($returnValue);

        $hmacGeneratorStub = $this->createMock(HmacGenerator::class);
        $hmacGeneratorStub->method('getHeader')
            ->willReturn('hmac mocked');
        $api = new Api($adapterStub, $hmacGeneratorStub);

        $cmd = new CreateRecord(
            'example.com',
            new DnsARecord(
                '',
                'blog',
                3600,
                '127.0.0.1'
            )
        );

        $recordId = $api->executeCommand($cmd);
        $this->assertEquals('1-9988776610', $recordId);
        $this->assertEquals('201', $api->getResponseCode());
    }

    public function testCreateCAARecord(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('CAA record type is not supported by the API');

        new CreateRecord(
            'example.com',
            new DnsCAARecord(
                '',
                '',
                3600,
                '128 issue "letsencrypt.org"'
            )
        );
    }
}

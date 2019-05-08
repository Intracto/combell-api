<?php

namespace Test\Command\Dns;

use PHPUnit\Framework\TestCase;

use TomCan\CombellApi\Adapter\AdapterInterface;
use TomCan\CombellApi\Common\HmacGenerator;
use TomCan\CombellApi\Common\Api;

use TomCan\CombellApi\Command\Dns\GetRecord;
use TomCan\CombellApi\Structure\Dns\DnsARecord;

final class GetRecordTest extends TestCase
{
    public function testCall(): void
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
                'Date' => ['Sat, 02 Feb 2019 20:23:35 GMT'],
            ],
            'body' => json_encode(
                (object)[
                    'id' => '1-1122334455',
                    'type' => 'A',
                    'record_name' => '',
                    'ttl' => 3600,
                    'content' => '127.0.0.1',
                    'service' => null,
                    'target' => null,
                    'protocol' => null,
                    'priority' => 0,
                    'port' => null,
                    'weight' => null,
                ]
            )
        ];

        $adapterStub = $this->createMock(AdapterInterface::class);
        $headers = [
            'Authorization' => 'hmac mocked',
            'Accept' => 'application/json',
            'Content-type' => 'application/json',
        ];
        $adapterStub->method('call')
            ->with('GET', 'https://api.combell.com/v2/dns/example.com/records/1-1122334455', $headers, '')
            ->willReturn($returnValue);

        $hmacGeneratorStub = $this->createMock(HmacGenerator::class);
        $hmacGeneratorStub->method('getHeader')
            ->willReturn('hmac mocked');
        $api = new Api($adapterStub, $hmacGeneratorStub);

        $cmd = new GetRecord('example.com', '1-1122334455');
        /** @var DnsARecord $record */
        $record = $api->executeCommand($cmd);

        $this->assertInstanceOf(DnsARecord::class, $record);
        $this->assertEquals('A', $record->getType());
        $this->assertEquals(3600, $record->getTtl());
        $this->assertEquals('127.0.0.1', $record->getContent());
    }
}

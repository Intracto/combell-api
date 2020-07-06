<?php

namespace Test\Command\MysqlDatabases;

use PHPUnit\Framework\TestCase;
use TomCan\CombellApi\Adapter\AdapterInterface;
use TomCan\CombellApi\Common\HmacGenerator;
use TomCan\CombellApi\Common\Api;
use TomCan\CombellApi\Command\LinuxHostings\SetGzipCompression;

final class SetGzipCompressionTest extends TestCase
{
    public function testSetGzipCompression(): void
    {
        $returnValue = [
            'status' => 204,
            'headers' => [
                'Transfer-Encoding' => ['chunked'],
                'Content-Type' => ['application/json; charset=utf-8'],
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
            ->with('PUT', 'https://api.combell.com/v2/linuxhostings/example.com/settings/gzipcompression', $headers, '{"enabled":true}')
            ->willReturn($returnValue);

        $hmacGeneratorStub = $this->createMock(HmacGenerator::class);
        $hmacGeneratorStub->method('getHeader')
            ->willReturn('hmac mocked');
        $api = new Api($adapterStub, $hmacGeneratorStub);

        $cmd = new SetGzipCompression('example.com', true);
        $api->executeCommand($cmd);

        $this->assertEquals('204', $api->getResponseCode());
    }
}

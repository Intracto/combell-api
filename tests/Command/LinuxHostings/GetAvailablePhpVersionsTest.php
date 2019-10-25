<?php

namespace Test\Command\MysqlDatabases;

use PHPUnit\Framework\TestCase;
use TomCan\CombellApi\Adapter\AdapterInterface;
use TomCan\CombellApi\Common\HmacGenerator;
use TomCan\CombellApi\Common\Api;
use TomCan\CombellApi\Command\LinuxHostings\GetAvailablePhpVersions;

final class GetAvailablePhpVersionsTest extends TestCase
{
    public function testGetAvailablePhpVersions(): void
    {
        $returnValue = [
            'status' => 200,
            'headers' => [
                'Content-Type' => ['application/json; charset=utf-8'],
                'X-RateLimit-Limit' => ['100'],
                'X-RateLimit-Usage' => ['1'],
                'X-RateLimit-Remaining' => ['99'],
                'X-RateLimit-Reset' => ['60'],
                'Date' => ['Sat, 02 Feb 2019 20:23:35 GMT'],
                'Content-Length' => ['300'],
            ],
            'body' => json_encode([
                (object) ['version' => '5.2'],
                (object) ['version' => '5.3'],
                (object) ['version' => '5.4'],
                (object) ['version' => '5.5'],
                (object) ['version' => '5.6'],
                (object) ['version' => '7.0'],
                (object) ['version' => '7.1'],
                (object) ['version' => '7.2'],
                (object) ['version' => '7.3'],
                (object) ['version' => '7.4'],
            ]),
        ];

        $adapterStub = $this->createMock(AdapterInterface::class);
        $headers = [
            'Authorization' => 'hmac mocked',
            'Accept' => 'application/json',
            'Content-type' => 'application/json',
        ];
        $adapterStub->method('call')
            ->with('GET', 'https://api.combell.com/v2/linuxhostings/example.com/phpsettings/availableversions', $headers, '')
            ->willReturn($returnValue);

        $hmacGeneratorStub = $this->createMock(HmacGenerator::class);
        $hmacGeneratorStub->method('getHeader')
            ->willReturn('hmac mocked');
        $api = new Api($adapterStub, $hmacGeneratorStub);

        $cmd = new GetAvailablePhpVersions('example.com');
        /** @var array $phpVersions */
        $phpVersions = $api->executeCommand($cmd);

        $this->assertIsArray($phpVersions);
        $this->assertCount(10, $phpVersions);
        $this->assertEquals('7.4', $phpVersions[9]);
    }
}

<?php

namespace Test\Command\Accounts;

use PHPUnit\Framework\TestCase;
use TomCan\CombellApi\Adapter\AdapterInterface;
use TomCan\CombellApi\Common\HmacGenerator;
use TomCan\CombellApi\Common\Api;
use TomCan\CombellApi\Command\Servicepacks\ListServicepacks;
use TomCan\CombellApi\Structure\Servicepacks\Servicepack;

final class ListServicepacksTest extends TestCase
{
    public function testListServicepacks(): void
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
                'Content-Length' => ['1024'],
            ],
            'body' => json_encode([
                (object) ['id' => 1000, 'name' => 'Linux start'],
                (object) ['id' => 1001, 'name' => 'Linux advanced'],
                (object) ['id' => 1002, 'name' => 'Linux pro'],
            ]),
        ];

        $adapterStub = $this->createMock(AdapterInterface::class);
        $headers = [
            'Authorization' => 'hmac mocked',
            'Accept' => 'application/json',
            'Content-type' => 'application/json',
        ];
        $adapterStub->method('call')
            ->with('GET', 'https://api.combell.com/v2/servicepacks', $headers, '')
            ->willReturn($returnValue);

        $hmacGeneratorStub = $this->createMock(HmacGenerator::class);
        $hmacGeneratorStub->method('getHeader')
            ->willReturn('hmac mocked');
        $api = new Api($adapterStub, $hmacGeneratorStub);

        $cmd = new ListServicepacks();
        $servicepacks = $api->executeCommand($cmd);

        $this->assertCount(3, $servicepacks);
        $this->assertInstanceOf(Servicepack::class, $servicepacks[1]);
        $this->assertEquals('1001', $servicepacks[1]->getId());
        $this->assertEquals('Linux advanced', $servicepacks[1]->getName());
    }
}

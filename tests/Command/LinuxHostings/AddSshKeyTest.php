<?php

namespace Test\Command\MysqlDatabases;

use PHPUnit\Framework\TestCase;

use TomCan\CombellApi\Adapter\AdapterInterface;
use TomCan\CombellApi\Common\HmacGenerator;
use TomCan\CombellApi\Common\Api;

use TomCan\CombellApi\Command\LinuxHostings\AddSshKey;

final class AddSshKeyTest extends TestCase
{
    public function testAddSshKey(): void
    {
        $returnValue = [
            'status' => 201,
            'headers' => [
                'Transfer-Encoding' => ['chunked'],
                'Content-Type' => ['application/json; charset=utf-8'],
                'X-RateLimit-Limit' => ['100'],
                'X-RateLimit-Usage' => ['1'],
                'X-RateLimit-Remaining' => ['99'],
                'X-RateLimit-Reset' => ['60'],
                'Date' => ['Sat, 02 Feb 2019 20:23:35 GMT'],
            ],
            'body' => '',
        ];

        $sshKey = 'ssh-ed25519 AAAAC3NzaC1lZDI1NTE5AAAAIM1bF+CMFcrYQGgTDkvwF10woeWbfBHGiPJWLmN1Cnjl user@laptop';

        $adapterStub = $this->createMock(AdapterInterface::class);
        $headers = [
            'Authorization' => 'hmac mocked',
            'Accept' => 'application/json',
            'Content-type' => 'application/json',
        ];
        $adapterStub->method('call')
            ->with('POST', 'https://api.combell.com/v2/linuxhostings/example.com/ssh/keys', $headers, '{"public_key":"' . $sshKey . '"}')
            ->willReturn($returnValue);

        $hmacGeneratorStub = $this->createMock(HmacGenerator::class);
        $hmacGeneratorStub->method('getHeader')
            ->willReturn('hmac mocked');
        $api = new Api($adapterStub, $hmacGeneratorStub);

        $cmd = new AddSshKey('example.com', $sshKey);
        $api->executeCommand($cmd);

        $this->assertEquals('201', $api->getResponseCode());
    }
}

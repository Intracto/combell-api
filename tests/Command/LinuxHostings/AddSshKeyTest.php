<?php

namespace Test\Command\LinuxHostings;

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
                'x-ratelimit-limit' => ['100'],
                'x-ratelimit-usage' => ['1'],
                'x-ratelimit-remaining' => ['99'],
                'x-ratelimit-reset' => ['60'],
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
            ->with('POST', 'https://api.combell.com/v2/linuxhostings/example.com/ssh/keys', $headers, '{"public_key":"'.$sshKey.'"}')
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

<?php

namespace Test\Command\Dns;

use PHPUnit\Framework\TestCase;
use TomCan\CombellApi\Adapter\AdapterInterface;
use TomCan\CombellApi\Command\LinuxHostings\DeleteSshKey;
use TomCan\CombellApi\Common\HmacGenerator;
use TomCan\CombellApi\Common\Api;

final class DeleteSshKeyTest extends TestCase
{
    public function testDeleteRecord(): void
    {
        $returnValue = [
            'status' => 204,
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
            ->with('DELETE', 'https://api.combell.com/v2/linuxhostings/example.com/ssh/keys/0123456789abcdef', $headers, '')
            ->willReturn($returnValue);

        $hmacGeneratorStub = $this->createMock(HmacGenerator::class);
        $hmacGeneratorStub->method('getHeader')
            ->willReturn('hmac mocked');
        $api = new Api($adapterStub, $hmacGeneratorStub);

        $cmd = new DeleteSshKey(
            'example.com',
            '0123456789abcdef'
        );

        $response = $api->executeCommand($cmd);
        $this->assertNull($response);
        $this->assertEquals('204', $api->getResponseCode());

    }
}

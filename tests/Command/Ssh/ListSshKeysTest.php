<?php

namespace Test\Command\Ssh;

use PHPUnit\Framework\TestCase;
use TomCan\CombellApi\Adapter\AdapterInterface;
use TomCan\CombellApi\Command\Ssh\ListSshKeys;
use TomCan\CombellApi\Common\HmacGenerator;
use TomCan\CombellApi\Common\Api;
use TomCan\CombellApi\Structure\Ssh\SshKey;

final class ListSshKeysTest extends TestCase
{
    public function testListSshKeys(): void
    {
        $returnValue = [
            'status' => 200,
            'headers' => [
                'Content-Type' => ['application/json; charset=utf-8'],
                'X-RateLimit-Limit' => ['100'],
                'X-RateLimit-Usage' => ['1'],
                'X-RateLimit-Remaining' => ['99'],
                'X-RateLimit-Reset' => ['60'],
                'X-Paging-Skipped' => ['0'],
                'X-Paging-Take' => ['25'],
                'X-Paging-TotalResults' => ['3'],
                'Date' => ['Sat, 02 Feb 2019 20:23:35 GMT'],
                'Content-Length' => ['1024'],
            ],
            'body' => json_encode([
                (object) ['linux_hostings' => ['example.com', 'secure.example.com'], 'fingerprint' => '0123456789abcdef', 'public_key' => 'ssh-rsa AAAAB...1 example-key-1@example.com'],
                (object) ['linux_hostings' => ['example.com'], 'fingerprint' => '1123456789abcdef', 'public_key' => 'ssh-rsa AAAAB...2 example-key-2@example.com'],
                (object) ['linux_hostings' => [], 'fingerprint' => '2123456789abcdef', 'public_key' => 'ssh-rsa AAAAB...3 example-key-3@example.com'],
            ]),
        ];

        $adapterStub = $this->createMock(AdapterInterface::class);
        $headers = [
            'Authorization' => 'hmac mocked',
            'Accept' => 'application/json',
            'Content-type' => 'application/json',
        ];
        $adapterStub->method('call')
            ->with('GET', 'https://api.combell.com/v2/ssh', $headers, '')
            ->willReturn($returnValue);

        $hmacGeneratorStub = $this->createMock(HmacGenerator::class);
        $hmacGeneratorStub->method('getHeader')
            ->willReturn('hmac mocked');
        $api = new Api($adapterStub, $hmacGeneratorStub);

        $cmd = new ListSshKeys();
        /** @var SshKey[] $sshKeys */
        $sshKeys = $api->executeCommand($cmd);

        $this->assertCount(3, $sshKeys);
        $this->assertInstanceOf(SshKey::class, $sshKeys[1]);
        $this->assertEquals('0123456789abcdef', $sshKeys[0]->getFingerprint());
        $this->assertEquals('ssh-rsa AAAAB...2 example-key-2@example.com', $sshKeys[1]->getPublicKey());
        $this->assertCount(1, $sshKeys[1]->getLinuxHostings());
        $this->assertCount(0, $sshKeys[2]->getLinuxHostings());
    }
}

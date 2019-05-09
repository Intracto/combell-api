<?php

namespace Test\Command\Mailboxes;

use PHPUnit\Framework\TestCase;

use TomCan\CombellApi\Adapter\AdapterInterface;
use TomCan\CombellApi\Common\HmacGenerator;
use TomCan\CombellApi\Common\Api;

use TomCan\CombellApi\Command\Mailboxes\GetQuota;
use TomCan\CombellApi\Structure\Mailbox\Quota;

final class GetQuotaTest extends TestCase
{
    public function testGetQuota(): void
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
                'Content-Length' => ['115'],
            ],
            'body' => json_encode([
                (object)['size' => '1000', 'account_id' => '123456'],
                (object)['size' => '1000', 'account_id' => '123457'],
            ])
        ];

        $adapterStub = $this->createMock(AdapterInterface::class);
        $headers = [
            'Authorization' => 'hmac mocked',
            'Accept' => 'application/json',
            'Content-type' => 'application/json',
        ];
        $adapterStub->method('call')
            ->with('GET', 'https://api.combell.com/v2/mailboxes/example.com/quota', $headers, '')
            ->willReturn($returnValue);

        $hmacGeneratorStub = $this->createMock(HmacGenerator::class);
        $hmacGeneratorStub->method('getHeader')
            ->willReturn('hmac mocked');
        $api = new Api($adapterStub, $hmacGeneratorStub);

        $cmd = new GetQuota('example.com');
        $quotas = $api->executeCommand($cmd);

        $this->assertInstanceOf(Quota::class, $quotas[0]);
        $this->assertEquals(1000, $quotas[0]->getSize());
        $this->assertEquals(123456, $quotas[0]->getAccountId());
    }
}

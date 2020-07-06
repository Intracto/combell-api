<?php

namespace Test\Command\Mailboxes;

use PHPUnit\Framework\TestCase;
use TomCan\CombellApi\Adapter\AdapterInterface;
use TomCan\CombellApi\Common\HmacGenerator;
use TomCan\CombellApi\Common\Api;
use TomCan\CombellApi\Command\Mailboxes\CreateMailbox;

final class CreateMailboxTest extends TestCase
{
    public function testCreateMailbox(): void
    {
        $returnValue = [
            'status' => 201,
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
            ->with('POST', 'https://api.combell.com/v2/mailboxes/example.com', $headers, '{"email":"info@example.com","password":"blaBLA123","account_id":123456}')
            ->willReturn($returnValue);

        $hmacGeneratorStub = $this->createMock(HmacGenerator::class);
        $hmacGeneratorStub->method('getHeader')
            ->willReturn('hmac mocked');
        $api = new Api($adapterStub, $hmacGeneratorStub);

        $cmd = new CreateMailbox(
            'example.com',
            'info@example.com',
            'blaBLA123',
            123456
        );

        $api->executeCommand($cmd);

        $this->assertEquals('201', $api->getResponseCode());
    }
}

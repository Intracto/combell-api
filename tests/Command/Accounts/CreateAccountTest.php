<?php

namespace Test\Command\Accounts;

use PHPUnit\Framework\TestCase;
use TomCan\CombellApi\Adapter\AdapterInterface;
use TomCan\CombellApi\Common\HmacGenerator;
use TomCan\CombellApi\Common\Api;
use TomCan\CombellApi\Command\Accounts\CreateAccount;
use TomCan\CombellApi\Structure\ProvisioningJobs\ProvisioningJob;

final class CreateAccountTest extends TestCase
{
    public function testCreateAccount(): void
    {
        $returnValue = [
            'status' => 202,
            'headers' => [
                'Content-Length' => ['0'],
                'Location' => ['/v2/provisioningjobs/8ds73fds-fc0d-783s-b092-beec98322200'],
                'X-RateLimit-Limit' => ['100'],
                'X-RateLimit-Usage' => ['1'],
                'X-RateLimit-Remaining' => ['99'],
                'X-RateLimit-Reset' => ['60'],
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
            ->with('POST', 'https://api.combell.com/v2/accounts', $headers, '{"identifier":"blog.example.com","servicepack_id":1001,"ftp_password":"blaBLA123"}')
            ->willReturn($returnValue);

        $hmacGeneratorStub = $this->createMock(HmacGenerator::class);
        $hmacGeneratorStub->method('getHeader')
            ->willReturn('hmac mocked');
        $api = new Api($adapterStub, $hmacGeneratorStub);

        $cmd = new CreateAccount(
            'blog.example.com',
            1001,
            'blaBLA123'
        );

        /** @var ProvisioningJob $provisionJob */
        $provisionJobLink = $api->executeCommand($cmd);
        $this->assertEquals('8ds73fds-fc0d-783s-b092-beec98322200', $provisionJobLink);

        $this->assertEquals('202', $api->getResponseCode());
    }

    public function testAccountPasswordSpecialCharacters(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('Password can\'t contain special characters');

        new CreateAccount(
            'test.example.com',
            1001,
            'testTEST123##'
        );
    }

    public function testAccountPasswordLength(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('Password must be between 8-20 characters long');

        new CreateAccount(
            'test.example.com',
            1001,
            'testtes'
        );
        new CreateAccount(
            'test.example.com',
            1001,
            'testtesttesttesttestt'
        );
    }

    public function testAccountPasswordComplexity(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('Password must be a mix of letters and digits');

        new CreateAccount(
            'test.example.com',
            1001,
            'testtest'
        );
        new CreateAccount(
            'test.example.com',
            1001,
            'testTEST'
        );
        new CreateAccount(
            'test.example.com',
            1001,
            'test1234'
        );
    }
}

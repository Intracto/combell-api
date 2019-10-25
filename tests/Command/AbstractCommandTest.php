<?php

namespace Test\Command\Accounts;

use PHPUnit\Framework\TestCase;
use TomCan\CombellApi\Adapter\AdapterInterface;
use TomCan\CombellApi\Common\HmacGenerator;
use TomCan\CombellApi\Common\Api;
use TomCan\CombellApi\Command\Accounts\ListAccounts;
use TomCan\CombellApi\Structure\Accounts\Account;

final class AbstractCommandTest extends TestCase
{
    public function testSkipTake(): void
    {
        $returnValue = [
            'status' => 200,
            'headers' => [
                'Transfer-Encoding' => ['chunked'],
                'Content-Type' => ['application/json; charset=utf-8'],
                'X-RateLimit-Limit' => ['100'],
                'X-RateLimit-Usage' => ['1'],
                'X-RateLimit-Remaining' => ['99'],
                'X-RateLimit-Reset' => ['60'],
                'X-Paging-Skipped' => ['50'],
                'X-Paging-Take' => ['2'],
                'X-Paging-TotalResults' => ['7899'],
                'Date' => ['Sat, 02 Feb 2019 20:23:35 GMT'],
            ],
            'body' => json_encode([
                (object) ['id' => 999051, 'identifier' => '01012018999051.example.com', 'servicepack_id' => 1001],
                (object) ['id' => 999052, 'identifier' => '01012018999052.example.com', 'servicepack_id' => 1002],
            ]),
        ];

        $adapterStub = $this->createMock(AdapterInterface::class);
        $headers = [
            'Authorization' => 'hmac mocked',
            'Accept' => 'application/json',
            'Content-type' => 'application/json',
        ];
        $adapterStub->method('call')
            ->with('GET', 'https://api.combell.com/v2/accounts?skip=50&take=2', $headers, '')
            ->willReturn($returnValue);

        $hmacGeneratorStub = $this->createMock(HmacGenerator::class);
        $hmacGeneratorStub->method('getHeader')
            ->willReturn('hmac mocked');
        $api = new Api($adapterStub, $hmacGeneratorStub);

        $cmd = new ListAccounts();
        $cmd->setSkip(50);
        $cmd->setTake(2);
        /** @var Account[] $accounts */
        $accounts = $api->executeCommand($cmd);

        $this->assertEquals(50, $cmd->getPagingSkipped());
        $this->assertEquals(2, $cmd->getPagingTake());
        $this->assertEquals(7899, $cmd->getPagingTotalResults());

        $this->assertCount(2, $accounts);
        $this->assertInstanceOf(Account::class, $accounts[1]);
        $this->assertEquals(999052, $accounts[1]->getId());
        $this->assertEquals('01012018999052.example.com', $accounts[1]->getIdentifier());
        $this->assertEquals(1002, $accounts[1]->getServicepackId());
    }
}

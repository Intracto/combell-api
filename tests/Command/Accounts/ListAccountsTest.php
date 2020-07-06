<?php

namespace Test\Command\Accounts;

use PHPUnit\Framework\TestCase;
use TomCan\CombellApi\Adapter\AdapterInterface;
use TomCan\CombellApi\Common\HmacGenerator;
use TomCan\CombellApi\Common\Api;
use TomCan\CombellApi\Command\Accounts\ListAccounts;
use TomCan\CombellApi\Structure\Accounts\Account;

final class ListAccountsTest extends TestCase
{
    public function testValidAssetTypes(): void
    {
        foreach (['domain', 'linux_hosting', 'mysql', 'dns', 'mailbox'] as $type) {
            $this->assertInstanceOf(
                ListAccounts::class,
                new ListAccounts($type, 'id.example.com')
            );
        }
    }

    public function testInvalidAssetTypes(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('Invalid asset type specified');

        new ListAccounts('invalid_asset_type');
    }

    public function testListAccounts(): void
    {
        $returnValue = [
            'status' => 200,
            'headers' => [
                'Transfer-Encoding' => ['chunked'],
                'Content-Type' => ['application/json; charset=utf-8'],
                'x-ratelimit-limit' => ['100'],
                'x-ratelimit-usage' => ['1'],
                'x-ratelimit-remaining' => ['99'],
                'x-ratelimit-reset' => ['60'],
                'x-paging-skipped' => ['0'],
                'x-paging-take' => ['25'],
                'x-paging-totalresults' => ['12345'],
                'Date' => ['Sat, 02 Feb 2019 20:23:35 GMT'],
            ],
            'body' => json_encode([
                (object) ['id' => 999001, 'identifier' => '01012018999001.example.com', 'servicepack_id' => 1001],
                (object) ['id' => 999002, 'identifier' => '01012018999002.example.com', 'servicepack_id' => 1002],
                (object) ['id' => 999003, 'identifier' => '01012018999003.example.com', 'servicepack_id' => 1003],
                (object) ['id' => 999004, 'identifier' => '01012018999004.example.com', 'servicepack_id' => 1004],
                (object) ['id' => 999005, 'identifier' => '01012018999005.example.com', 'servicepack_id' => 1001],
                (object) ['id' => 999006, 'identifier' => '01012018999006.example.com', 'servicepack_id' => 1002],
                (object) ['id' => 999007, 'identifier' => '01012018999007.example.com', 'servicepack_id' => 1003],
                (object) ['id' => 999008, 'identifier' => '01012018999008.example.com', 'servicepack_id' => 1004],
                (object) ['id' => 999009, 'identifier' => '01012018999009.example.com', 'servicepack_id' => 1001],
                (object) ['id' => 999010, 'identifier' => '01012018999010.example.com', 'servicepack_id' => 1002],
                (object) ['id' => 999011, 'identifier' => '01012018999011.example.com', 'servicepack_id' => 1003],
                (object) ['id' => 999012, 'identifier' => '01012018999012.example.com', 'servicepack_id' => 1004],
                (object) ['id' => 999013, 'identifier' => '01012018999013.example.com', 'servicepack_id' => 1001],
                (object) ['id' => 999014, 'identifier' => '01012018999014.example.com', 'servicepack_id' => 1002],
                (object) ['id' => 999015, 'identifier' => '01012018999015.example.com', 'servicepack_id' => 1003],
                (object) ['id' => 999016, 'identifier' => '01012018999016.example.com', 'servicepack_id' => 1004],
                (object) ['id' => 999017, 'identifier' => '01012018999017.example.com', 'servicepack_id' => 1001],
                (object) ['id' => 999018, 'identifier' => '01012018999018.example.com', 'servicepack_id' => 1002],
                (object) ['id' => 999019, 'identifier' => '01012018999019.example.com', 'servicepack_id' => 1003],
                (object) ['id' => 999020, 'identifier' => '01012018999020.example.com', 'servicepack_id' => 1004],
                (object) ['id' => 999021, 'identifier' => '01012018999021.example.com', 'servicepack_id' => 1001],
                (object) ['id' => 999022, 'identifier' => '01012018999022.example.com', 'servicepack_id' => 1002],
                (object) ['id' => 999023, 'identifier' => '01012018999023.example.com', 'servicepack_id' => 1003],
                (object) ['id' => 999024, 'identifier' => '01012018999024.example.com', 'servicepack_id' => 1004],
                (object) ['id' => 999025, 'identifier' => '01012018999025.example.com', 'servicepack_id' => 1001],
            ]),
        ];

        $adapterStub = $this->createMock(AdapterInterface::class);
        $headers = [
            'Authorization' => 'hmac mocked',
            'Accept' => 'application/json',
            'Content-type' => 'application/json',
        ];
        $adapterStub->method('call')
            ->with('GET', 'https://api.combell.com/v2/accounts?skip=0&take=25&asset_type=linux_hosting', $headers, '')
            ->willReturn($returnValue);

        $hmacGeneratorStub = $this->createMock(HmacGenerator::class);
        $hmacGeneratorStub->method('getHeader')
            ->willReturn('hmac mocked');
        $api = new Api($adapterStub, $hmacGeneratorStub);

        $cmd = new ListAccounts('linux_hosting');
        /** @var Account[] $accounts */
        $accounts = $api->executeCommand($cmd);

        $this->assertEquals(0, $cmd->getPagingSkipped());
        $this->assertEquals(25, $cmd->getPagingTake());
        $this->assertEquals(12345, $cmd->getPagingTotalResults());

        $this->assertCount(25, $accounts);
        $this->assertInstanceOf(Account::class, $accounts[7]);
        $this->assertEquals('999008', $accounts[7]->getId());
        $this->assertEquals('01012018999008.example.com', $accounts[7]->getIdentifier());
        $this->assertEquals(1004, $accounts[7]->getServicepackId());
    }
}

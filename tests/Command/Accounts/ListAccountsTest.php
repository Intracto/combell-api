<?php

use PHPUnit\Framework\TestCase;

use TomCan\CombellApi\Common\Api;
use TomCan\CombellApi\Command\Accounts\ListAccounts;
use TomCan\CombellApi\Structure\Accounts\Account;

final class ListAccountsTest extends TestCase
{
    public function testValidAssetTypes(): void
    {
        $cmd = new ListAccounts();

        foreach (['domain', 'linux_hosting', 'mysql', 'dns', 'mailbox'] as $type) {
            $cmd->setIdentifier($type);
            $this->assertEquals($cmd->getIdentifier(), $type);
        }
    }

    public function testInvalidAssetTypes(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('Invalid asset type specified');

        new ListAccounts('invalid_asset_type');
    }

    public function testCall(): void
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
                'X-Paging-Skipped' => ['0'],
                'X-Paging-Take' => ['25'],
                'X-Paging-TotalResults' => ['12345'],
                'Date' => ['Sat, 02 Feb 2019 20:23:35 GMT'],
            ],
            'body' => json_encode([
                (object) [ 'id' => 999001, 'identifier' => '01012018999001.example.com' ],
                (object) [ 'id' => 999002, 'identifier' => '01012018999002.example.com' ],
                (object) [ 'id' => 999003, 'identifier' => '01012018999003.example.com' ],
                (object) [ 'id' => 999004, 'identifier' => '01012018999004.example.com' ],
                (object) [ 'id' => 999005, 'identifier' => '01012018999005.example.com' ],
                (object) [ 'id' => 999006, 'identifier' => '01012018999006.example.com' ],
                (object) [ 'id' => 999007, 'identifier' => '01012018999007.example.com' ],
                (object) [ 'id' => 999008, 'identifier' => '01012018999008.example.com' ],
                (object) [ 'id' => 999009, 'identifier' => '01012018999009.example.com' ],
                (object) [ 'id' => 999010, 'identifier' => '01012018999010.example.com' ],
                (object) [ 'id' => 999011, 'identifier' => '01012018999011.example.com' ],
                (object) [ 'id' => 999012, 'identifier' => '01012018999012.example.com' ],
                (object) [ 'id' => 999013, 'identifier' => '01012018999013.example.com' ],
                (object) [ 'id' => 999014, 'identifier' => '01012018999014.example.com' ],
                (object) [ 'id' => 999015, 'identifier' => '01012018999015.example.com' ],
                (object) [ 'id' => 999016, 'identifier' => '01012018999016.example.com' ],
                (object) [ 'id' => 999017, 'identifier' => '01012018999017.example.com' ],
                (object) [ 'id' => 999018, 'identifier' => '01012018999018.example.com' ],
                (object) [ 'id' => 999019, 'identifier' => '01012018999019.example.com' ],
                (object) [ 'id' => 999020, 'identifier' => '01012018999020.example.com' ],
                (object) [ 'id' => 999021, 'identifier' => '01012018999021.example.com' ],
                (object) [ 'id' => 999022, 'identifier' => '01012018999022.example.com' ],
                (object) [ 'id' => 999023, 'identifier' => '01012018999023.example.com' ],
                (object) [ 'id' => 999024, 'identifier' => '01012018999024.example.com' ],
                (object) [ 'id' => 999025, 'identifier' => '01012018999025.example.com' ],
            ])
        ];

        $stub = $this->createMock(\TomCan\CombellApi\Adapter\AdapterInterface::class);
        $stub->method('call')->willReturn($returnValue);

        $api = new Api('', '', $stub);

        $this->assertEquals(100, $api->getRateLimitLimit());
        $this->assertEquals(0, $api->getRateLimitUsage());
        $this->assertEquals(100, $api->getRateLimitRemaining());
        $this->assertEquals(60, $api->getRateLimitReset());

        $cmd = new ListAccounts();
        $accounts = $api->executeCommand($cmd);

        $this->assertEquals(100, $api->getRateLimitLimit());
        $this->assertEquals(1, $api->getRateLimitUsage());
        $this->assertEquals(99, $api->getRateLimitRemaining());
        $this->assertEquals(60, $api->getRateLimitReset());

        $this->assertEquals(0, $cmd->getPagingSkipped());
        $this->assertEquals(25, $cmd->getPagingTake());
        $this->assertEquals(12345, $cmd->getPagingTotalResults());

        $this->assertCount(25, $accounts);
        $this->assertInstanceOf(Account::class, $accounts[7]);
        $this->assertEquals('999008', $accounts[7]->getId());
        $this->assertEquals('01012018999008.example.com', $accounts[7]->getIdentifier());
    }
}

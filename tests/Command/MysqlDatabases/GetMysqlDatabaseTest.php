<?php

namespace Test\Command\MysqlDatabases;

use PHPUnit\Framework\TestCase;
use TomCan\CombellApi\Adapter\AdapterInterface;
use TomCan\CombellApi\Common\HmacGenerator;
use TomCan\CombellApi\Common\Api;
use TomCan\CombellApi\Command\MysqlDatabases\GetMysqlDatabase;
use TomCan\CombellApi\Structure\MysqlDatabases\MysqlDatabase;

final class GetMysqlDatabaseTest extends TestCase
{
    public function testGetMysqlDatabase(): void
    {
        $returnValue = [
            'status' => 200,
            'headers' => [
                'Content-Type' => ['application/json; charset=utf-8'],
                'x-ratelimit-limit' => ['100'],
                'x-ratelimit-usage' => ['1'],
                'x-ratelimit-remaining' => ['99'],
                'x-ratelimit-reset' => ['60'],
                'Date' => ['Sat, 02 Feb 2019 20:23:35 GMT'],
                'Content-Length' => ['165'],
            ],
            'body' => json_encode(
                (object) [
                    'name' => 'ID111125_tests',
                    'hostname' => 'ID111125_tests.db.webhosting.be',
                    'user_count' => 2,
                    'max_size' => 250,
                    'actual_size' => 5,
                    'account_id' => 123456,
                ]
            ),
        ];

        $adapterStub = $this->createMock(AdapterInterface::class);
        $headers = [
            'Authorization' => 'hmac mocked',
            'Accept' => 'application/json',
            'Content-type' => 'application/json',
        ];
        $adapterStub->method('call')
            ->with('GET', 'https://api.combell.com/v2/mysqldatabases/ID111125_child', $headers, '')
            ->willReturn($returnValue);

        $hmacGeneratorStub = $this->createMock(HmacGenerator::class);
        $hmacGeneratorStub->method('getHeader')
            ->willReturn('hmac mocked');
        $api = new Api($adapterStub, $hmacGeneratorStub);

        $cmd = new GetMysqlDatabase('ID111125_child');
        /** @var MysqlDatabase $database */
        $database = $api->executeCommand($cmd);

        $this->assertInstanceOf(MysqlDatabase::class, $database);
        $this->assertEquals(123456, $database->getAccountId());
        $this->assertEquals('ID111125_tests', $database->getName());
        $this->assertEquals('ID111125_tests.db.webhosting.be', $database->getHostname());
        $this->assertEquals(2, $database->getUserCount());
        $this->assertEquals(250, $database->getMaxSize());
        $this->assertEquals(5, $database->getActualSize());
    }
}

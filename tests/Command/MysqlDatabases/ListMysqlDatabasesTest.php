<?php

namespace Test\Command\MysqlDatabases;

use PHPUnit\Framework\TestCase;

use TomCan\CombellApi\Adapter\AdapterInterface;
use TomCan\CombellApi\Common\HmacGenerator;
use TomCan\CombellApi\Common\Api;

use TomCan\CombellApi\Command\MysqlDatabases\ListMysqlDatabases;
use TomCan\CombellApi\Structure\MysqlDatabases\MysqlDatabase;

final class ListMysqlDatabasesTest extends TestCase
{
    public function testCall(): void
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
                'X-Paging-TotalResults' => ['234'],
                'Date' => ['Sat, 02 Feb 2019 20:23:35 GMT'],
                'Content-Length' => ['4726'],
            ],
            'body' => json_encode([
                (object) [ 'name' => 'ID111101_tests', 'hostname' => 'ID111101_tests.db.webhosting.be', 'user_count' => 2, 'max_size' => 250, 'actual_size' => 5, 'account_id' => 123456],
                (object) [ 'name' => 'ID111102_tests', 'hostname' => 'ID111102_tests.db.webhosting.be', 'user_count' => 2, 'max_size' => 250, 'actual_size' => 5, 'account_id' => 123456],
                (object) [ 'name' => 'ID111103_tests', 'hostname' => 'ID111103_tests.db.webhosting.be', 'user_count' => 2, 'max_size' => 250, 'actual_size' => 5, 'account_id' => 123456],
                (object) [ 'name' => 'ID111104_tests', 'hostname' => 'ID111104_tests.db.webhosting.be', 'user_count' => 2, 'max_size' => 250, 'actual_size' => 5, 'account_id' => 123456],
                (object) [ 'name' => 'ID111105_tests', 'hostname' => 'ID111105_tests.db.webhosting.be', 'user_count' => 2, 'max_size' => 250, 'actual_size' => 5, 'account_id' => 123456],
                (object) [ 'name' => 'ID111106_tests', 'hostname' => 'ID111106_tests.db.webhosting.be', 'user_count' => 2, 'max_size' => 250, 'actual_size' => 5, 'account_id' => 123456],
                (object) [ 'name' => 'ID111107_tests', 'hostname' => 'ID111107_tests.db.webhosting.be', 'user_count' => 2, 'max_size' => 250, 'actual_size' => 5, 'account_id' => 123456],
                (object) [ 'name' => 'ID111108_tests', 'hostname' => 'ID111108_tests.db.webhosting.be', 'user_count' => 2, 'max_size' => 250, 'actual_size' => 5, 'account_id' => 123456],
                (object) [ 'name' => 'ID111109_tests', 'hostname' => 'ID111109_tests.db.webhosting.be', 'user_count' => 2, 'max_size' => 250, 'actual_size' => 5, 'account_id' => 123456],
                (object) [ 'name' => 'ID111110_tests', 'hostname' => 'ID111110_tests.db.webhosting.be', 'user_count' => 2, 'max_size' => 250, 'actual_size' => 5, 'account_id' => 123456],
                (object) [ 'name' => 'ID111111_tests', 'hostname' => 'ID111111_tests.db.webhosting.be', 'user_count' => 2, 'max_size' => 250, 'actual_size' => 5, 'account_id' => 123456],
                (object) [ 'name' => 'ID111112_tests', 'hostname' => 'ID111112_tests.db.webhosting.be', 'user_count' => 2, 'max_size' => 250, 'actual_size' => 5, 'account_id' => 123456],
                (object) [ 'name' => 'ID111113_tests', 'hostname' => 'ID111113_tests.db.webhosting.be', 'user_count' => 2, 'max_size' => 250, 'actual_size' => 5, 'account_id' => 123456],
                (object) [ 'name' => 'ID111114_tests', 'hostname' => 'ID111114_tests.db.webhosting.be', 'user_count' => 2, 'max_size' => 250, 'actual_size' => 5, 'account_id' => 123456],
                (object) [ 'name' => 'ID111115_tests', 'hostname' => 'ID111115_tests.db.webhosting.be', 'user_count' => 2, 'max_size' => 250, 'actual_size' => 5, 'account_id' => 123456],
                (object) [ 'name' => 'ID111116_tests', 'hostname' => 'ID111116_tests.db.webhosting.be', 'user_count' => 2, 'max_size' => 250, 'actual_size' => 5, 'account_id' => 123456],
                (object) [ 'name' => 'ID111117_tests', 'hostname' => 'ID111117_tests.db.webhosting.be', 'user_count' => 2, 'max_size' => 250, 'actual_size' => 5, 'account_id' => 123456],
                (object) [ 'name' => 'ID111118_tests', 'hostname' => 'ID111118_tests.db.webhosting.be', 'user_count' => 2, 'max_size' => 250, 'actual_size' => 5, 'account_id' => 123456],
                (object) [ 'name' => 'ID111119_tests', 'hostname' => 'ID111119_tests.db.webhosting.be', 'user_count' => 2, 'max_size' => 250, 'actual_size' => 5, 'account_id' => 123456],
                (object) [ 'name' => 'ID111120_tests', 'hostname' => 'ID111120_tests.db.webhosting.be', 'user_count' => 2, 'max_size' => 250, 'actual_size' => 5, 'account_id' => 123456],
                (object) [ 'name' => 'ID111121_tests', 'hostname' => 'ID111121_tests.db.webhosting.be', 'user_count' => 2, 'max_size' => 250, 'actual_size' => 5, 'account_id' => 123456],
                (object) [ 'name' => 'ID111122_tests', 'hostname' => 'ID111122_tests.db.webhosting.be', 'user_count' => 2, 'max_size' => 250, 'actual_size' => 5, 'account_id' => 123456],
                (object) [ 'name' => 'ID111123_tests', 'hostname' => 'ID111123_tests.db.webhosting.be', 'user_count' => 2, 'max_size' => 250, 'actual_size' => 5, 'account_id' => 123456],
                (object) [ 'name' => 'ID111124_tests', 'hostname' => 'ID111124_tests.db.webhosting.be', 'user_count' => 2, 'max_size' => 250, 'actual_size' => 5, 'account_id' => 123456],
                (object) [ 'name' => 'ID111125_tests', 'hostname' => 'ID111125_tests.db.webhosting.be', 'user_count' => 2, 'max_size' => 250, 'actual_size' => 5, 'account_id' => 123456],
            ])
        ];

        $adapterStub = $this->createMock(AdapterInterface::class);
        $headers = [
            'Authorization' => 'hmac mocked',
            'Accept' => 'application/json',
            'Content-type' => 'application/json',
        ];
        $adapterStub->method('call')
            ->with('GET', 'https://api.combell.com/v2/mysqldatabases?skip=0&take=25', $headers, '')
            ->willReturn($returnValue);

        $hmacGeneratorStub = $this->createMock(HmacGenerator::class);
        $hmacGeneratorStub->method('getHeader')
            ->willReturn('hmac mocked');
        $api = new Api($adapterStub, $hmacGeneratorStub);

        $cmd = new ListMysqlDatabases();
        $databases = $api->executeCommand($cmd);

        $this->assertEquals(0, $cmd->getPagingSkipped());
        $this->assertEquals(25, $cmd->getPagingTake());
        $this->assertEquals(234, $cmd->getPagingTotalResults());

        $this->assertCount(25, $databases);
        $this->assertInstanceOf(MysqlDatabase::class, $databases[7]);
        $this->assertEquals(123456, $databases[7]->getAccountId());
        $this->assertEquals('ID111108_tests', $databases[7]->getName());
        $this->assertEquals('ID111108_tests.db.webhosting.be', $databases[7]->getHostname());
        $this->assertEquals(2, $databases[7]->getUserCount());
        $this->assertEquals(250, $databases[7]->getMaxSize());
        $this->assertEquals(5, $databases[7]->getActualSize());
    }
}

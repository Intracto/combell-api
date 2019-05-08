<?php

namespace Test\Command\MysqlDatabases;

use PHPUnit\Framework\TestCase;

use TomCan\CombellApi\Adapter\AdapterInterface;
use TomCan\CombellApi\Common\HmacGenerator;
use TomCan\CombellApi\Common\Api;

use TomCan\CombellApi\Command\MysqlDatabases\CreateMysqlDatabase;

final class CreateMysqlDatabaseTest extends TestCase
{
    public function testCall(): void
    {
        $returnValue = [
            'status' => 202,
            'headers' => [
                'Content-Length' => ['0'],
                'Location' => '/v2/provisioningjobs/d7cbf26f-9c7f-4851-bd0a-317acfb4bf4d',
                'Retry-After' => '5',
                'X-RateLimit-Limit' => ['100'],
                'X-RateLimit-Usage' => ['1'],
                'X-RateLimit-Remaining' => ['99'],
                'X-RateLimit-Reset' => ['60'],
                'Date' => ['Sat, 02 Feb 2019 20:23:35 GMT'],
            ],
            'body' => ''
        ];

        $adapterStub = $this->createMock(AdapterInterface::class);
        $headers = [
            'Authorization' => 'hmac mocked',
            'Accept' => 'application/json',
            'Content-type' => 'application/json',
        ];
        $adapterStub->method('call')
            ->with('POST', 'https://api.combell.com/v2/mysqldatabases', $headers, '{"database_name":"dbname","account_id":1000001,"password":"secretpassword"}')
            ->willReturn($returnValue);

        $hmacGeneratorStub = $this->createMock(HmacGenerator::class);
        $hmacGeneratorStub->method('getHeader')
            ->willReturn('hmac mocked');
        $api = new Api($adapterStub, $hmacGeneratorStub);

        $cmd = new CreateMysqlDatabase(
            'dbname',
            1000001,
            'secretpassword'
        );

        $provisionJobsId = $api->executeCommand($cmd);

        $this->assertEquals('d7cbf26f-9c7f-4851-bd0a-317acfb4bf4d', $provisionJobsId);

        $this->assertEquals('202', $api->getResponseCode());
    }
}

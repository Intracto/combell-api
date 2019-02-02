<?php

use PHPUnit\Framework\TestCase;

use TomCan\CombellApi\Command\Accounts\GetAccount;
use TomCan\CombellApi\Structure\Accounts\Account;

final class GetAccountTest extends TestCase
{
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
                'Date' => ['Sat, 02 Feb 2019 20:23:35 GMT'],
            ],
            'body' => json_encode(
                (object) [ 'id' => 999015, 'identifier' => '01012018999015.example.com' ],
            )
        ];

        $stub = $this->createMock(\TomCan\CombellApi\Adapter\AdapterInterface::class);
        $stub->method('call')->willReturn($returnValue);

        $api = new \TomCan\CombellApi\Common\Api('', '', $stub);

        $cmd = new GetAccount(15);
        $account = $api->executeCommand($cmd);

        $this->assertInstanceOf(Account::class, $account);
        $this->assertEquals('999015', $account->getId());
        $this->assertEquals('01012018999015.example.com', $account->getIdentifier());
    }
}

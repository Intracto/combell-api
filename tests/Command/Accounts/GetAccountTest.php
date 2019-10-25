<?php

namespace Test\Command\Accounts;

use PHPUnit\Framework\TestCase;

use TomCan\CombellApi\Adapter\AdapterInterface;
use TomCan\CombellApi\Common\HmacGenerator;
use TomCan\CombellApi\Common\Api;

use TomCan\CombellApi\Command\Accounts\GetAccount;
use TomCan\CombellApi\Structure\Accounts\Account;

final class GetAccountTest extends TestCase
{
    public function testGetAccount(): void
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
                (object) [
                    'id' => 999015,
                    'identifier' => 'example.com',
                    'servicepack' => (object) [
                        'id' => 1040,
                        'name' => 'Basic E-Mail'
                    ],
                    'addons' => [
                        (object) [
                            'id' => 1099,
                            'name' => 'Basic 1-pack addon',
                        ]
                    ]
                ]
            )
        ];

        $adapterStub = $this->createMock(AdapterInterface::class);
        $headers = [
            'Authorization' => 'hmac mocked',
            'Accept' => 'application/json',
            'Content-type' => 'application/json',
        ];
        $adapterStub->method('call')
            ->with('GET', 'https://api.combell.com/v2/accounts/15', $headers, '')
            ->willReturn($returnValue);

        $hmacGeneratorStub = $this->createMock(HmacGenerator::class);
        $hmacGeneratorStub->method('getHeader')
            ->willReturn('hmac mocked');
        $api = new Api($adapterStub, $hmacGeneratorStub);

        $cmd = new GetAccount(15);
        /** @var $account Account */
        $account = $api->executeCommand($cmd);

        $this->assertInstanceOf(Account::class, $account);
        $this->assertEquals('999015', $account->getId());
        $this->assertEquals('example.com', $account->getIdentifier());
        $this->assertEquals(1040, $account->getServicepackId());
        $this->assertCount(1, $account->getAddons());
        $this->assertEquals(1099, $account->getAddons()[0]);
    }
}

<?php

use PHPUnit\Framework\TestCase;

use TomCan\CombellApi\Command\Domains\GetDomain;
use TomCan\CombellApi\Structure\Domains\Domain;
use TomCan\CombellApi\Structure\Domains\NameServer;

final class GetRecordTest extends TestCase
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
                (object)[
                    'domain_name' => '15.example.com',
                    'expiration_date' => '2019-12-23T23:00:00Z',
                    'will_renew' => null,
                    'name_servers' => [
                        (object)['name' => 'NS3.EUROPEAN-SERVER.COM', 'ip' => '217.21.190.81'],
                        (object)['name' => 'NS4.EUROPEAN-SERVER.COM', 'ip' => '86.39.202.67'],
                    ],
                ]
            )
        ];

        $stub = $this->createMock(\TomCan\CombellApi\Adapter\AdapterInterface::class);
        $stub->method('call')->willReturn($returnValue);

        $api = new \TomCan\CombellApi\Common\Api('', '', $stub);

        $cmd = new GetDomain('15.example.com');
        $domain = $api->executeCommand($cmd);

        $this->assertInstanceOf(Domain::class, $domain);
        $this->assertEquals('15.example.com', $domain->getDomainName());
        $this->assertEquals(new \DateTime('2019-12-23T23:00:00Z'), $domain->getExpirationDate());
        $this->assertNull($domain->getWillRenew());

        $this->assertCount(2, $domain->getNameServers());
        $this->assertInstanceOf(NameServer::class, $domain->getNameServers()[0]);
        $this->assertEquals('NS3.EUROPEAN-SERVER.COM', $domain->getNameServers()[0]->getDomainName());
        $this->assertEquals('217.21.190.81', $domain->getNameServers()[0]->getIp());
    }
}

<?php

use PHPUnit\Framework\TestCase;

use TomCan\CombellApi\Command\Domains\GetDomain;
use TomCan\CombellApi\Structure\Domains\Domain;

final class GetDomainTest extends TestCase
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
                (object) [ 'domain_name' => '15.example.com', 'expiration_date' => '2019-12-23T23:00:00Z', 'will_renew' => true],
            )
        ];

        $stub = $this->createMock(\TomCan\CombellApi\Adapter\AdapterInterface::class);
        $stub->method('call')->willReturn($returnValue);

        $api = new \TomCan\CombellApi\Common\Api('', '', $stub);

        $cmd = new GetDomain(15);
        $domain = $api->executeCommand($cmd);

        $this->assertInstanceOf(Domain::class, $domain);
        $this->assertEquals('15.example.com', $domain->getDomainName());
        $this->assertEquals(new \DateTime('2019-12-23T23:00:00Z'), $domain->getExpirationDate());
        $this->assertTrue($domain->getWillRenew());
    }
}

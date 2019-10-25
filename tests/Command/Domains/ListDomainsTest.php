<?php

namespace Test\Command\Domains;

use PHPUnit\Framework\TestCase;
use TomCan\CombellApi\Adapter\AdapterInterface;
use TomCan\CombellApi\Common\HmacGenerator;
use TomCan\CombellApi\Common\Api;
use TomCan\CombellApi\Command\Domains\ListDomains;
use TomCan\CombellApi\Structure\Domains\Domain;

final class ListDomainsTest extends TestCase
{
    public function testListDomains(): void
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
                'X-Paging-TotalResults' => ['1234'],
                'Date' => ['Sat, 02 Feb 2019 20:23:35 GMT'],
            ],
            'body' => json_encode([
                (object) ['domain_name' => '01.example.com', 'expiration_date' => '2019-12-23T23:00:00Z', 'will_renew' => true],
                (object) ['domain_name' => '02.example.com', 'expiration_date' => '2019-12-23T23:00:00Z', 'will_renew' => true],
                (object) ['domain_name' => '03.example.com', 'expiration_date' => '2019-12-23T23:00:00Z', 'will_renew' => true],
                (object) ['domain_name' => '04.example.com', 'expiration_date' => '2019-12-23T23:00:00Z', 'will_renew' => true],
                (object) ['domain_name' => '05.example.com', 'expiration_date' => '2019-12-23T23:00:00Z', 'will_renew' => true],
                (object) ['domain_name' => '06.example.com', 'expiration_date' => '2019-12-23T23:00:00Z', 'will_renew' => true],
                (object) ['domain_name' => '07.example.com', 'expiration_date' => '2019-12-23T23:00:00Z', 'will_renew' => true],
                (object) ['domain_name' => '08.example.com', 'expiration_date' => '2019-12-23T23:00:00Z', 'will_renew' => true],
                (object) ['domain_name' => '09.example.com', 'expiration_date' => '2019-12-23T23:00:00Z', 'will_renew' => true],
                (object) ['domain_name' => '10.example.com', 'expiration_date' => '2019-12-23T23:00:00Z', 'will_renew' => true],
                (object) ['domain_name' => '11.example.com', 'expiration_date' => '2019-12-23T23:00:00Z', 'will_renew' => true],
                (object) ['domain_name' => '12.example.com', 'expiration_date' => '2019-12-23T23:00:00Z', 'will_renew' => true],
                (object) ['domain_name' => '13.example.com', 'expiration_date' => '2019-12-23T23:00:00Z', 'will_renew' => true],
                (object) ['domain_name' => '14.example.com', 'expiration_date' => '2019-12-23T23:00:00Z', 'will_renew' => true],
                (object) ['domain_name' => '15.example.com', 'expiration_date' => '2019-12-23T23:00:00Z', 'will_renew' => true],
                (object) ['domain_name' => '16.example.com', 'expiration_date' => '2019-12-23T23:00:00Z', 'will_renew' => true],
                (object) ['domain_name' => '17.example.com', 'expiration_date' => '2019-12-23T23:00:00Z', 'will_renew' => true],
                (object) ['domain_name' => '18.example.com', 'expiration_date' => '2019-12-23T23:00:00Z', 'will_renew' => true],
                (object) ['domain_name' => '19.example.com', 'expiration_date' => '2019-12-23T23:00:00Z', 'will_renew' => true],
                (object) ['domain_name' => '20.example.com', 'expiration_date' => '2019-12-23T23:00:00Z', 'will_renew' => true],
                (object) ['domain_name' => '21.example.com', 'expiration_date' => '2019-12-23T23:00:00Z', 'will_renew' => true],
                (object) ['domain_name' => '22.example.com', 'expiration_date' => '2019-12-23T23:00:00Z', 'will_renew' => true],
                (object) ['domain_name' => '23.example.com', 'expiration_date' => '2019-12-23T23:00:00Z', 'will_renew' => true],
                (object) ['domain_name' => '24.example.com', 'expiration_date' => '2019-12-23T23:00:00Z', 'will_renew' => true],
                (object) ['domain_name' => '25.example.com', 'expiration_date' => '2019-12-23T23:00:00Z', 'will_renew' => true],
            ]),
        ];

        $adapterStub = $this->createMock(AdapterInterface::class);
        $headers = [
            'Authorization' => 'hmac mocked',
            'Accept' => 'application/json',
            'Content-type' => 'application/json',
        ];
        $adapterStub->method('call')
            ->with('GET', 'https://api.combell.com/v2/domains?skip=0&take=25', $headers, '')
            ->willReturn($returnValue);

        $hmacGeneratorStub = $this->createMock(HmacGenerator::class);
        $hmacGeneratorStub->method('getHeader')
            ->willReturn('hmac mocked');
        $api = new Api($adapterStub, $hmacGeneratorStub);

        $cmd = new ListDomains();
        $domains = $api->executeCommand($cmd);

        $this->assertEquals(0, $cmd->getPagingSkipped());
        $this->assertEquals(25, $cmd->getPagingTake());
        $this->assertEquals(1234, $cmd->getPagingTotalResults());

        $this->assertCount(25, $domains);
        $this->assertInstanceOf(Domain::class, $domains[7]);
        $this->assertEquals('08.example.com', $domains[7]->getDomainName());
        $this->assertEquals(new \DateTime('2019-12-23T23:00:00Z'), $domains[7]->getExpirationDate());
        $this->assertTrue($domains[7]->getWillRenew());
        $this->assertEmpty($domains[7]->getNameServers());
    }
}

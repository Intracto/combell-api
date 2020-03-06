<?php

namespace Test\Command\LinuxHostings;

use PHPUnit\Framework\TestCase;
use TomCan\CombellApi\Adapter\AdapterInterface;
use TomCan\CombellApi\Common\HmacGenerator;
use TomCan\CombellApi\Common\Api;
use TomCan\CombellApi\Command\LinuxHostings\ListLinuxHostings;
use TomCan\CombellApi\Structure\LinuxHostings\LinuxHostingSummary;

final class ListLinuxHostingsTest extends TestCase
{
    public function testListLinuxHostings(): void
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
                'X-Paging-TotalResults' => ['1244'],
                'Date' => ['Sat, 02 Feb 2019 20:23:35 GMT'],
            ],
            'body' => json_encode([
                (object) ['domain_name' => 'example-01.com', 'servicepack_id' => '1000'],
                (object) ['domain_name' => 'example-02.com', 'servicepack_id' => '1001'],
                (object) ['domain_name' => 'example-03.com', 'servicepack_id' => '1002'],
                (object) ['domain_name' => 'example-04.com', 'servicepack_id' => '1000'],
                (object) ['domain_name' => 'example-05.com', 'servicepack_id' => '1001'],
                (object) ['domain_name' => 'example-06.com', 'servicepack_id' => '1002'],
                (object) ['domain_name' => 'example-07.com', 'servicepack_id' => '1000'],
                (object) ['domain_name' => 'example-08.com', 'servicepack_id' => '1001'],
                (object) ['domain_name' => 'example-09.com', 'servicepack_id' => '1002'],
                (object) ['domain_name' => 'example-10.com', 'servicepack_id' => '1000'],
                (object) ['domain_name' => 'example-11.com', 'servicepack_id' => '1001'],
                (object) ['domain_name' => 'example-12.com', 'servicepack_id' => '1002'],
                (object) ['domain_name' => 'example-13.com', 'servicepack_id' => '1000'],
                (object) ['domain_name' => 'example-14.com', 'servicepack_id' => '1001'],
                (object) ['domain_name' => 'example-15.com', 'servicepack_id' => '1002'],
                (object) ['domain_name' => 'example-16.com', 'servicepack_id' => '1000'],
                (object) ['domain_name' => 'example-17.com', 'servicepack_id' => '1001'],
                (object) ['domain_name' => 'example-18.com', 'servicepack_id' => '1002'],
                (object) ['domain_name' => 'example-19.com', 'servicepack_id' => '1000'],
                (object) ['domain_name' => 'example-20.com', 'servicepack_id' => '1001'],
                (object) ['domain_name' => 'example-21.com', 'servicepack_id' => '1002'],
                (object) ['domain_name' => 'example-22.com', 'servicepack_id' => '1000'],
                (object) ['domain_name' => 'example-23.com', 'servicepack_id' => '1001'],
                (object) ['domain_name' => 'example-24.com', 'servicepack_id' => '1002'],
                (object) ['domain_name' => 'example-25.com', 'servicepack_id' => '1000'],
            ]),
        ];

        $adapterStub = $this->createMock(AdapterInterface::class);
        $headers = [
            'Authorization' => 'hmac mocked',
            'Accept' => 'application/json',
            'Content-type' => 'application/json',
        ];
        $adapterStub->method('call')
            ->with('GET', 'https://api.combell.com/v2/linuxhostings?skip=0&take=25', $headers, '')
            ->willReturn($returnValue);

        $hmacGeneratorStub = $this->createMock(HmacGenerator::class);
        $hmacGeneratorStub->method('getHeader')
            ->willReturn('hmac mocked');
        $api = new Api($adapterStub, $hmacGeneratorStub);

        $cmd = new ListLinuxHostings();
        /** @var LinuxHostingSummary[] $linuxHostings */
        $linuxHostings = $api->executeCommand($cmd);

        $this->assertEquals(0, $cmd->getPagingSkipped());
        $this->assertEquals(25, $cmd->getPagingTake());
        $this->assertEquals(1244, $cmd->getPagingTotalResults());

        $this->assertCount(25, $linuxHostings);
        $this->assertInstanceOf(LinuxHostingSummary::class, $linuxHostings[7]);
        $this->assertEquals('example-08.com', $linuxHostings[7]->getDomainName());
        $this->assertEquals('1001', $linuxHostings[7]->getServicepackId());
    }
}

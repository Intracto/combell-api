<?php

namespace Test\Command\Dns;

use PHPUnit\Framework\TestCase;

use TomCan\CombellApi\Adapter\AdapterInterface;
use TomCan\CombellApi\Common\HmacGenerator;
use TomCan\CombellApi\Common\Api;

use TomCan\CombellApi\Command\Dns\ListRecords;
use TomCan\CombellApi\Structure\Dns\DnsARecord;
use TomCan\CombellApi\Structure\Dns\DnsMXRecord;
use TomCan\CombellApi\Structure\Dns\DnsNSRecord;
use TomCan\CombellApi\Structure\Dns\DnsSOARecord;
use TomCan\CombellApi\Structure\Dns\DnsTXTRecord;
use TomCan\CombellApi\Structure\Dns\DnsSRVRecord;
use TomCan\CombellApi\Structure\Dns\DnsCNAMERecord;
use TomCan\CombellApi\Structure\Dns\DnsAAAARecord;
use TomCan\CombellApi\Structure\Dns\DnsCAARecord;

final class ListRecordsTest extends TestCase
{
    public function testListRecords(): void
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
                'X-Paging-Take' => ['9'],
                'X-Paging-TotalResults' => ['9'],
                'Date' => ['Sat, 02 Feb 2019 20:23:35 GMT'],
            ],
            'body' => json_encode([
                (object) [
                    'id' => '1-9988776601',
                    'type' => 'A',
                    'record_name' => 'www',
                    'ttl' => 3600,
                    'content' => '127.0.0.1',
                    'service' => null,
                    'target' => null,
                    'protocol' => null,
                    'priority' => null,
                    'port' => null,
                    'weight' => null,
                ],
                (object) [
                    'id' => '1-9988776602',
                    'type' => 'MX',
                    'record_name' => '',
                    'ttl' => 3600,
                    'content' => 'mail01.example.com',
                    'service' => null,
                    'target' => null,
                    'protocol' => null,
                    'priority' => 10,
                    'port' => null,
                    'weight' => null,
                ],
                (object) [
                    'id' => '1-9988776603',
                    'type' => 'NS',
                    'record_name' => '',
                    'ttl' => 3600,
                    'content' => 'ns3.european-server.com',
                    'service' => null,
                    'target' => null,
                    'protocol' => null,
                    'priority' => null,
                    'port' => null,
                    'weight' => null,
                ],
                (object) [
                    'id' => '1-9988776604',
                    'type' => 'SOA',
                    'record_name' => '',
                    'ttl' => 3600,
                    'content' => 'ns3.european-server.com hostmaster.example.com 2019020901 10800 3600 604800 40000',
                    'service' => null,
                    'target' => null,
                    'protocol' => null,
                    'priority' => null,
                    'port' => null,
                    'weight' => null,
                ],
                (object) [
                    'id' => '1-9988776605',
                    'type' => 'TXT',
                    'record_name' => '',
                    'ttl' => 3600,
                    'content' => 'v=spf1 mx a -all',
                    'service' => null,
                    'target' => null,
                    'protocol' => null,
                    'priority' => null,
                    'port' => null,
                    'weight' => null,
                ],
                (object) [
                    'id' => '1-9988776606',
                    'type' => 'SRV',
                    'record_name' => '_submission._tcp',
                    'ttl' => 3600,
                    'content' => '1 587 smtp-auth.example.com',
                    'service' => '_submission',
                    'target' => 'smtp-auth.example.com',
                    'protocol' => '_tcp',
                    'priority' => 1,
                    'port' => 587,
                    'weight' => 1,
                ],
                (object) [
                    'id' => '1-9988776607',
                    'type' => 'CNAME',
                    'record_name' => 'smtp',
                    'ttl' => 3600,
                    'content' => 'mail.example.com',
                    'service' => null,
                    'target' => null,
                    'protocol' => null,
                    'priority' => 0,
                    'port' => null,
                    'weight' => null,
                ],
                (object) [
                    'id' => '1-9988776608',
                    'type' => 'AAAA',
                    'record_name' => 'localhost',
                    'ttl' => 3600,
                    'content' => '::1',
                    'service' => null,
                    'target' => null,
                    'protocol' => null,
                    'priority' => 0,
                    'port' => null,
                    'weight' => null,
                ],
                (object) [
                    'id' => '1-9988776609',
                    'type' => 'CAA',
                    'record_name' => '',
                    'ttl' => 3600,
                    'content' => '128 issue "letsencrypt.org"',
                    'service' => null,
                    'target' => null,
                    'protocol' => null,
                    'priority' => 0,
                    'port' => null,
                    'weight' => null,
                ],
            ]),
        ];

        $adapterStub = $this->createMock(AdapterInterface::class);
        $headers = [
            'Authorization' => 'hmac mocked',
            'Accept' => 'application/json',
            'Content-type' => 'application/json',
        ];
        $adapterStub->method('call')
            ->with('GET', 'https://api.combell.com/v2/dns/example.com/records?skip=0&take=25', $headers, '')
            ->willReturn($returnValue);

        $hmacGeneratorStub = $this->createMock(HmacGenerator::class);
        $hmacGeneratorStub->method('getHeader')
            ->willReturn('hmac mocked');
        $api = new Api($adapterStub, $hmacGeneratorStub);

        $cmd = new ListRecords('example.com');
        $domains = $api->executeCommand($cmd);

        $this->assertEquals(0, $cmd->getPagingSkipped());
        $this->assertEquals(9, $cmd->getPagingTake());
        $this->assertEquals(9, $cmd->getPagingTotalResults());

        $this->assertCount(9, $domains);

        $this->assertInstanceOf(DnsARecord::class, $domains[0]);
        $this->assertEquals('www', $domains[0]->getHostName());
        $this->assertEquals('127.0.0.1', $domains[0]->getContent());
        $this->assertEquals(3600, $domains[0]->getTtl());

        $this->assertInstanceOf(DnsMXRecord::class, $domains[1]);
        $this->assertEquals('', $domains[1]->getHostName());
        $this->assertEquals('mail01.example.com', $domains[1]->getContent());
        $this->assertEquals('10', $domains[1]->getPriority());

        $this->assertInstanceOf(DnsNSRecord::class, $domains[2]);
        $this->assertEquals('ns3.european-server.com', $domains[2]->getContent());

        $this->assertInstanceOf(DnsSOARecord::class, $domains[3]);
        $this->assertEquals('ns3.european-server.com hostmaster.example.com 2019020901 10800 3600 604800 40000', $domains[3]->getContent());

        $this->assertInstanceOf(DnsTXTRecord::class, $domains[4]);
        $this->assertEquals('v=spf1 mx a -all', $domains[4]->getContent());

        $this->assertInstanceOf(DnsSRVRecord::class, $domains[5]);
        $this->assertEquals('_submission._tcp', $domains[5]->getHostName());
        $this->assertEquals('_submission', $domains[5]->getService());
        $this->assertEquals('smtp-auth.example.com', $domains[5]->getTarget());
        $this->assertEquals('_tcp', $domains[5]->getProtocol());
        $this->assertEquals(1, $domains[5]->getPriority());
        $this->assertEquals(587, $domains[5]->getPort());
        $this->assertEquals(1, $domains[5]->getWeight());

        $this->assertInstanceOf(DnsCNAMERecord::class, $domains[6]);
        $this->assertEquals('smtp', $domains[6]->getHostName());
        $this->assertEquals('mail.example.com', $domains[6]->getContent());

        $this->assertInstanceOf(DnsAAAARecord::class, $domains[7]);
        $this->assertEquals('localhost', $domains[7]->getHostName());
        $this->assertEquals('::1', $domains[7]->getContent());

        $this->assertInstanceOf(DnsCAARecord::class, $domains[8]);
        $this->assertEquals('', $domains[8]->getHostName());
        $this->assertEquals('128 issue "letsencrypt.org"', $domains[8]->getContent());
    }

    public function testListRecordsWithUnknownType(): void
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
                'X-Paging-Take' => ['9'],
                'X-Paging-TotalResults' => ['9'],
                'Date' => ['Sat, 02 Feb 2019 20:23:35 GMT'],
            ],
            'body' => json_encode([
                (object) [
                    'id' => '1-9988776601',
                    'type' => 'TOM',
                    'record_name' => 'www',
                    'ttl' => 3600,
                    'content' => '127.0.0.1',
                    'service' => null,
                    'target' => null,
                    'protocol' => null,
                    'priority' => null,
                    'port' => null,
                    'weight' => null,
                ],
            ]),
        ];

        $adapterStub = $this->createMock(AdapterInterface::class);
        $headers = [
            'Authorization' => 'hmac mocked',
            'Accept' => 'application/json',
            'Content-type' => 'application/json',
        ];
        $adapterStub->method('call')
            ->with('GET', 'https://api.combell.com/v2/dns/example.com/records?skip=0&take=25', $headers, '')
            ->willReturn($returnValue);

        $hmacGeneratorStub = $this->createMock(HmacGenerator::class);
        $hmacGeneratorStub->method('getHeader')
            ->willReturn('hmac mocked');
        $api = new Api($adapterStub, $hmacGeneratorStub);

        $cmd = new ListRecords('example.com');

        $this->expectException(\LogicException::class);
        $this->expectExceptionMessage('Unknown DNS record type TOM');

        $domains = $api->executeCommand($cmd);

    }

}

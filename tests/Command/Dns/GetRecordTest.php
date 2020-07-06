<?php

namespace Test\Command\Dns;

use PHPUnit\Framework\TestCase;
use TomCan\CombellApi\Adapter\AdapterInterface;
use TomCan\CombellApi\Common\HmacGenerator;
use TomCan\CombellApi\Common\Api;
use TomCan\CombellApi\Command\Dns\GetRecord;
use TomCan\CombellApi\Structure\Dns\DnsARecord;
use TomCan\CombellApi\Structure\Dns\DnsAAAARecord;
use TomCan\CombellApi\Structure\Dns\DnsNSRecord;
use TomCan\CombellApi\Structure\Dns\DnsTXTRecord;
use TomCan\CombellApi\Structure\Dns\DnsCNAMERecord;
use TomCan\CombellApi\Structure\Dns\DnsSOARecord;
use TomCan\CombellApi\Structure\Dns\DnsCAARecord;
use TomCan\CombellApi\Structure\Dns\DnsMXRecord;
use TomCan\CombellApi\Structure\Dns\DnsSRVRecord;

final class GetRecordTest extends TestCase
{
    public function testGetARecord(): void
    {
        $returnValue = [
            'status' => 200,
            'headers' => [
                'Transfer-Encoding' => ['chunked'],
                'Content-Type' => ['application/json; charset=utf-8'],
                'x-ratelimit-limit' => ['100'],
                'x-ratelimit-usage' => ['1'],
                'x-ratelimit-remaining' => ['99'],
                'x-ratelimit-reset' => ['60'],
                'Date' => ['Sat, 02 Feb 2019 20:23:35 GMT'],
            ],
            'body' => json_encode(
                (object) [
                    'id' => '1-1122334455',
                    'type' => 'A',
                    'record_name' => '',
                    'ttl' => 3600,
                    'content' => '127.0.0.1',
                    'service' => null,
                    'target' => null,
                    'protocol' => null,
                    'priority' => 0,
                    'port' => null,
                    'weight' => null,
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
            ->with('GET', 'https://api.combell.com/v2/dns/example.com/records/1-1122334455', $headers, '')
            ->willReturn($returnValue);

        $hmacGeneratorStub = $this->createMock(HmacGenerator::class);
        $hmacGeneratorStub->method('getHeader')
            ->willReturn('hmac mocked');
        $api = new Api($adapterStub, $hmacGeneratorStub);

        $cmd = new GetRecord('example.com', '1-1122334455');
        /** @var DnsARecord $record */
        $record = $api->executeCommand($cmd);

        $this->assertInstanceOf(DnsARecord::class, $record);
        $this->assertEquals('A', $record->getType());
        $this->assertEquals(3600, $record->getTtl());
        $this->assertEquals('127.0.0.1', $record->getContent());
    }

    public function testGetAAAARecord(): void
    {
        $returnValue = [
            'status' => 200,
            'headers' => [
                'Transfer-Encoding' => ['chunked'],
                'Content-Type' => ['application/json; charset=utf-8'],
                'x-ratelimit-limit' => ['100'],
                'x-ratelimit-usage' => ['1'],
                'x-ratelimit-remaining' => ['99'],
                'x-ratelimit-reset' => ['60'],
                'Date' => ['Sat, 02 Feb 2019 20:23:35 GMT'],
            ],
            'body' => json_encode(
                (object) [
                    'id' => '1-1122334454',
                    'type' => 'AAAA',
                    'record_name' => '',
                    'ttl' => 3600,
                    'content' => '::1',
                    'service' => null,
                    'target' => null,
                    'protocol' => null,
                    'priority' => 0,
                    'port' => null,
                    'weight' => null,
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
            ->with('GET', 'https://api.combell.com/v2/dns/example.com/records/1-1122334454', $headers, '')
            ->willReturn($returnValue);

        $hmacGeneratorStub = $this->createMock(HmacGenerator::class);
        $hmacGeneratorStub->method('getHeader')
            ->willReturn('hmac mocked');
        $api = new Api($adapterStub, $hmacGeneratorStub);

        $cmd = new GetRecord('example.com', '1-1122334454');
        /** @var DnsAAAARecord $record */
        $record = $api->executeCommand($cmd);

        $this->assertInstanceOf(DnsAAAARecord::class, $record);
        $this->assertEquals('AAAA', $record->getType());
        $this->assertEquals(3600, $record->getTtl());
        $this->assertEquals('::1', $record->getContent());
    }

    public function testGetNSRecord(): void
    {
        $returnValue = [
            'status' => 200,
            'headers' => [
                'Transfer-Encoding' => ['chunked'],
                'Content-Type' => ['application/json; charset=utf-8'],
                'x-ratelimit-limit' => ['100'],
                'x-ratelimit-usage' => ['1'],
                'x-ratelimit-remaining' => ['99'],
                'x-ratelimit-reset' => ['60'],
                'Date' => ['Sat, 02 Feb 2019 20:23:35 GMT'],
            ],
            'body' => json_encode(
                (object) [
                    'id' => '1-1122334456',
                    'type' => 'NS',
                    'record_name' => '',
                    'ttl' => 86400,
                    'content' => 'ns3.european-server.com',
                    'service' => null,
                    'target' => null,
                    'protocol' => null,
                    'priority' => 0,
                    'port' => null,
                    'weight' => null,
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
            ->with('GET', 'https://api.combell.com/v2/dns/example.com/records/1-1122334456', $headers, '')
            ->willReturn($returnValue);

        $hmacGeneratorStub = $this->createMock(HmacGenerator::class);
        $hmacGeneratorStub->method('getHeader')
            ->willReturn('hmac mocked');
        $api = new Api($adapterStub, $hmacGeneratorStub);

        $cmd = new GetRecord('example.com', '1-1122334456');
        /** @var DnsNSRecord $record */
        $record = $api->executeCommand($cmd);

        $this->assertInstanceOf(DnsNSRecord::class, $record);
        $this->assertEquals('NS', $record->getType());
        $this->assertEquals(86400, $record->getTtl());
        $this->assertEquals('ns3.european-server.com', $record->getContent());
    }

    public function testGetTXTRecord(): void
    {
        $returnValue = [
            'status' => 200,
            'headers' => [
                'Transfer-Encoding' => ['chunked'],
                'Content-Type' => ['application/json; charset=utf-8'],
                'x-ratelimit-limit' => ['100'],
                'x-ratelimit-usage' => ['1'],
                'x-ratelimit-remaining' => ['99'],
                'x-ratelimit-reset' => ['60'],
                'Date' => ['Sat, 02 Feb 2019 20:23:35 GMT'],
            ],
            'body' => json_encode(
                (object) [
                    'id' => '1-1122334457',
                    'type' => 'TXT',
                    'record_name' => '',
                    'ttl' => 3600,
                    'content' => 'v=spf1 include:_spf.google.com ~all',
                    'service' => null,
                    'target' => null,
                    'protocol' => null,
                    'priority' => 0,
                    'port' => null,
                    'weight' => null,
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
            ->with('GET', 'https://api.combell.com/v2/dns/example.com/records/1-1122334457', $headers, '')
            ->willReturn($returnValue);

        $hmacGeneratorStub = $this->createMock(HmacGenerator::class);
        $hmacGeneratorStub->method('getHeader')
            ->willReturn('hmac mocked');
        $api = new Api($adapterStub, $hmacGeneratorStub);

        $cmd = new GetRecord('example.com', '1-1122334457');
        /** @var DnsTXTRecord $record */
        $record = $api->executeCommand($cmd);

        $this->assertInstanceOf(DnsTXTRecord::class, $record);
        $this->assertEquals('TXT', $record->getType());
        $this->assertEquals(3600, $record->getTtl());
        $this->assertEquals('v=spf1 include:_spf.google.com ~all', $record->getContent());
    }

    public function testGetCNAMERecord(): void
    {
        $returnValue = [
            'status' => 200,
            'headers' => [
                'Transfer-Encoding' => ['chunked'],
                'Content-Type' => ['application/json; charset=utf-8'],
                'x-ratelimit-limit' => ['100'],
                'x-ratelimit-usage' => ['1'],
                'x-ratelimit-remaining' => ['99'],
                'x-ratelimit-reset' => ['60'],
                'Date' => ['Sat, 02 Feb 2019 20:23:35 GMT'],
            ],
            'body' => json_encode(
                (object) [
                    'id' => '1-1122334458',
                    'type' => 'CNAME',
                    'record_name' => '',
                    'ttl' => 3600,
                    'content' => 'www.example.com',
                    'service' => null,
                    'target' => null,
                    'protocol' => null,
                    'priority' => 0,
                    'port' => null,
                    'weight' => null,
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
            ->with('GET', 'https://api.combell.com/v2/dns/example.com/records/1-1122334458', $headers, '')
            ->willReturn($returnValue);

        $hmacGeneratorStub = $this->createMock(HmacGenerator::class);
        $hmacGeneratorStub->method('getHeader')
            ->willReturn('hmac mocked');
        $api = new Api($adapterStub, $hmacGeneratorStub);

        $cmd = new GetRecord('example.com', '1-1122334458');
        /** @var DnsCNAMERecord $record */
        $record = $api->executeCommand($cmd);

        $this->assertInstanceOf(DnsCNAMERecord::class, $record);
        $this->assertEquals('CNAME', $record->getType());
        $this->assertEquals(3600, $record->getTtl());
        $this->assertEquals('www.example.com', $record->getContent());
    }

    public function testGetSOARecord(): void
    {
        $returnValue = [
            'status' => 200,
            'headers' => [
                'Transfer-Encoding' => ['chunked'],
                'Content-Type' => ['application/json; charset=utf-8'],
                'x-ratelimit-limit' => ['100'],
                'x-ratelimit-usage' => ['1'],
                'x-ratelimit-remaining' => ['99'],
                'x-ratelimit-reset' => ['60'],
                'Date' => ['Sat, 02 Feb 2019 20:23:35 GMT'],
            ],
            'body' => json_encode(
                (object) [
                    'id' => '1-1122334459',
                    'type' => 'SOA',
                    'record_name' => '',
                    'ttl' => 3600,
                    'content' => 'ns3.european-server.com hostmaster.example.com 2019010802 10800 3600 604800 40000',
                    'service' => null,
                    'target' => null,
                    'protocol' => null,
                    'priority' => 0,
                    'port' => null,
                    'weight' => null,
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
            ->with('GET', 'https://api.combell.com/v2/dns/example.com/records/1-1122334459', $headers, '')
            ->willReturn($returnValue);

        $hmacGeneratorStub = $this->createMock(HmacGenerator::class);
        $hmacGeneratorStub->method('getHeader')
            ->willReturn('hmac mocked');
        $api = new Api($adapterStub, $hmacGeneratorStub);

        $cmd = new GetRecord('example.com', '1-1122334459');
        /** @var DnsSOARecord $record */
        $record = $api->executeCommand($cmd);

        $this->assertInstanceOf(DnsSOARecord::class, $record);
        $this->assertEquals('SOA', $record->getType());
        $this->assertEquals(3600, $record->getTtl());
        $this->assertEquals('ns3.european-server.com hostmaster.example.com 2019010802 10800 3600 604800 40000', $record->getContent());
    }

    public function testGetCAARecord(): void
    {
        $returnValue = [
            'status' => 200,
            'headers' => [
                'Transfer-Encoding' => ['chunked'],
                'Content-Type' => ['application/json; charset=utf-8'],
                'x-ratelimit-limit' => ['100'],
                'x-ratelimit-usage' => ['1'],
                'x-ratelimit-remaining' => ['99'],
                'x-ratelimit-reset' => ['60'],
                'Date' => ['Sat, 02 Feb 2019 20:23:35 GMT'],
            ],
            'body' => json_encode(
                (object) [
                    'id' => '1-1122334460',
                    'type' => 'CAA',
                    'record_name' => '',
                    'ttl' => 3600,
                    'content' => '0 issue "letsencrypt.org"',
                    'service' => null,
                    'target' => null,
                    'protocol' => null,
                    'priority' => 0,
                    'port' => null,
                    'weight' => null,
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
            ->with('GET', 'https://api.combell.com/v2/dns/example.com/records/1-1122334460', $headers, '')
            ->willReturn($returnValue);

        $hmacGeneratorStub = $this->createMock(HmacGenerator::class);
        $hmacGeneratorStub->method('getHeader')
            ->willReturn('hmac mocked');
        $api = new Api($adapterStub, $hmacGeneratorStub);

        $cmd = new GetRecord('example.com', '1-1122334460');
        /** @var DnsCAARecord $record */
        $record = $api->executeCommand($cmd);

        $this->assertInstanceOf(DnsCAARecord::class, $record);
        $this->assertEquals('CAA', $record->getType());
        $this->assertEquals(3600, $record->getTtl());
        $this->assertEquals('0 issue "letsencrypt.org"', $record->getContent());
    }

    public function testGetMXRecord(): void
    {
        $returnValue = [
            'status' => 200,
            'headers' => [
                'Transfer-Encoding' => ['chunked'],
                'Content-Type' => ['application/json; charset=utf-8'],
                'x-ratelimit-limit' => ['100'],
                'x-ratelimit-usage' => ['1'],
                'x-ratelimit-remaining' => ['99'],
                'x-ratelimit-reset' => ['60'],
                'Date' => ['Sat, 02 Feb 2019 20:23:35 GMT'],
            ],
            'body' => json_encode(
                (object) [
                    'id' => '1-1122334461',
                    'type' => 'MX',
                    'record_name' => '',
                    'ttl' => 3600,
                    'content' => 'mx.mailprotect.be',
                    'service' => null,
                    'target' => null,
                    'protocol' => null,
                    'priority' => 10,
                    'port' => null,
                    'weight' => null,
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
            ->with('GET', 'https://api.combell.com/v2/dns/example.com/records/1-1122334461', $headers, '')
            ->willReturn($returnValue);

        $hmacGeneratorStub = $this->createMock(HmacGenerator::class);
        $hmacGeneratorStub->method('getHeader')
            ->willReturn('hmac mocked');
        $api = new Api($adapterStub, $hmacGeneratorStub);

        $cmd = new GetRecord('example.com', '1-1122334461');
        /** @var DnsMXRecord $record */
        $record = $api->executeCommand($cmd);

        $this->assertInstanceOf(DnsMXRecord::class, $record);
        $this->assertEquals('MX', $record->getType());
        $this->assertEquals(3600, $record->getTtl());
        $this->assertEquals('mx.mailprotect.be', $record->getContent());
        $this->assertEquals(10, $record->getPriority());
    }

    public function testGetSRVRecord(): void
    {
        $returnValue = [
            'status' => 200,
            'headers' => [
                'Transfer-Encoding' => ['chunked'],
                'Content-Type' => ['application/json; charset=utf-8'],
                'x-ratelimit-limit' => ['100'],
                'x-ratelimit-usage' => ['1'],
                'x-ratelimit-remaining' => ['99'],
                'x-ratelimit-reset' => ['60'],
                'Date' => ['Sat, 02 Feb 2019 20:23:35 GMT'],
            ],
            'body' => json_encode(
                (object) [
                    'id' => '1-1122334462',
                    'type' => 'SRV',
                    'record_name' => '_autodiscover._tcp',
                    'ttl' => 3600,
                    'content' => '1 443 autodiscover-s.mailprotect.be',
                    'service' => '_autodiscover',
                    'target' => 'autodiscover-s.mailprotect.be',
                    'protocol' => '_tcp',
                    'priority' => 1,
                    'port' => 443,
                    'weight' => 1,
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
            ->with('GET', 'https://api.combell.com/v2/dns/example.com/records/1-1122334462', $headers, '')
            ->willReturn($returnValue);

        $hmacGeneratorStub = $this->createMock(HmacGenerator::class);
        $hmacGeneratorStub->method('getHeader')
            ->willReturn('hmac mocked');
        $api = new Api($adapterStub, $hmacGeneratorStub);

        $cmd = new GetRecord('example.com', '1-1122334462');
        /** @var DnsSRVRecord $record */
        $record = $api->executeCommand($cmd);

        $this->assertInstanceOf(DnsSRVRecord::class, $record);
        $this->assertEquals('SRV', $record->getType());
        $this->assertEquals('_autodiscover._tcp', $record->getHostname());
        $this->assertEquals(3600, $record->getTtl());
        $this->assertEquals('_autodiscover', $record->getService());
        $this->assertEquals('autodiscover-s.mailprotect.be', $record->getTarget());
        $this->assertEquals('_tcp', $record->getProtocol());
        $this->assertEquals(1, $record->getPriority());
        $this->assertEquals(443, $record->getPort());
        $this->assertEquals(1, $record->getWeight());
    }

    public function testGetXXXRecord(): void
    {
        $returnValue = [
            'status' => 200,
            'headers' => [
                'Transfer-Encoding' => ['chunked'],
                'Content-Type' => ['application/json; charset=utf-8'],
                'x-ratelimit-limit' => ['100'],
                'x-ratelimit-usage' => ['1'],
                'x-ratelimit-remaining' => ['99'],
                'x-ratelimit-reset' => ['60'],
                'Date' => ['Sat, 02 Feb 2019 20:23:35 GMT'],
            ],
            'body' => json_encode(
                (object) [
                    'id' => '1-1122334462',
                    'type' => 'XXX',
                    'record_name' => '',
                    'ttl' => 3600,
                    'content' => '',
                    'service' => null,
                    'target' => null,
                    'protocol' => null,
                    'priority' => 10,
                    'port' => null,
                    'weight' => null,
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
            ->with('GET', 'https://api.combell.com/v2/dns/example.com/records/1-1122334463', $headers, '')
            ->willReturn($returnValue);

        $hmacGeneratorStub = $this->createMock(HmacGenerator::class);
        $hmacGeneratorStub->method('getHeader')
            ->willReturn('hmac mocked');
        $api = new Api($adapterStub, $hmacGeneratorStub);

        $cmd = new GetRecord('example.com', '1-1122334463');

        $this->expectException(\LogicException::class);
        $this->expectExceptionMessage('Unknown DNS record type XXX');

        /* @var DnsSRVRecord $record */
        $api->executeCommand($cmd);
    }
}

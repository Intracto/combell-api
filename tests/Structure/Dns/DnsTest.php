<?php

use PHPUnit\Framework\TestCase;

use TomCan\CombellApi\Structure\Dns\AbstractDnsRecord;
use TomCan\CombellApi\Structure\Dns\DnsAAAARecord;
use TomCan\CombellApi\Structure\Dns\DnsARecord;
use TomCan\CombellApi\Structure\Dns\DnsCAARecord;
use TomCan\CombellApi\Structure\Dns\DnsCNAMERecord;
use TomCan\CombellApi\Structure\Dns\DnsMXRecord;
use TomCan\CombellApi\Structure\Dns\DnsNSRecord;
use TomCan\CombellApi\Structure\Dns\DnsSOARecord;
use TomCan\CombellApi\Structure\Dns\DnsSRVRecord;
use TomCan\CombellApi\Structure\Dns\DnsTXTRecord;

final class DnsTest extends TestCase
{
    /**
     * Test the logic that is contained withing structures
     */
    public function testAbstractDnsRecord()
    {
        // test constructor
        $r = new AbstractDnsRecord('test-123', 'A', 'example.com', 123);
        $this->assertEquals('A', $r->getType());
        $this->assertEquals('test-123', $r->getId());
        $this->assertEquals('example.com', $r->getHostname());
        $this->assertEquals(123, $r->getTtl());

        // test object
        $o = $r->getObject();
        $this->doStandardObjectTests($r, $o);
    }

    private function doStandardObjectTests(AbstractDnsRecord $record, stdClass $object): void
    {
        // check if attributes exist
        $this->assertObjectHasAttribute('id', $object);
        $this->assertObjectHasAttribute('record_name', $object);
        $this->assertObjectHasAttribute('type', $object);
        $this->assertObjectHasAttribute('ttl', $object);

        // check if attribute values equal record values
        $this->assertEquals($record->getId(), $object->id);
        $this->assertEquals($record->getHostname(), $object->record_name);
        $this->assertEquals($record->getType(), $object->type);
        $this->assertEquals($record->getTtl(), $object->ttl);
    }

    /** @dataProvider dataHostnameValues */
    public function testAbstractDnsRecordHostnameValidation($value, $isValid)
    {
        if (!$isValid) {
            $this->expectException(InvalidArgumentException::class);
        }

        new AbstractDnsRecord('test-123', 'A', $value, 3600);

        $this->assertTrue($isValid);
    }

    /** @dataProvider dataUInt32Values */
    public function testAbstractDnsRecordTTLValidation($value, $isValid)
    {
        if (!$isValid) {
            $this->expectException(InvalidArgumentException::class);
        }

        new AbstractDnsRecord('test-123', 'A', 'example.com', $value);

        $this->assertTrue($isValid);
    }

    public function testDNSAAAARecord()
    {
        // test constructor
        $r = new DnsAAAARecord('test-123', 'example.com', 123, '::1');
        $this->assertEquals('AAAA', $r->getType());
        $this->assertEquals('test-123', $r->getId());
        $this->assertEquals('example.com', $r->getHostname());
        $this->assertEquals(123, $r->getTtl());
        $this->assertEquals('::1', $r->getContent());

        // test object
        $o = $r->getObject();
        $this->doStandardObjectTests($r, $o);
        $this->assertObjectHasAttribute('content', $o);
        $this->assertEquals($r->getContent(), $o->content);
    }

    /** @dataProvider dataIpv6Values */
    public function testDNSAAAARecordContentValidation($address, $isValid)
    {
        if (!$isValid) {
            $this->expectException(InvalidArgumentException::class);
        }

        new DnsAAAARecord('test-123', 'example.com', 123, $address);

        $this->assertTrue($isValid);
    }

    public function testDNSARecord()
    {
        // test constructor
        $r = new DnsARecord('test-123', 'example.com', 123, '127.0.0.1');
        $this->assertEquals('A', $r->getType());
        $this->assertEquals('test-123', $r->getId());
        $this->assertEquals('example.com', $r->getHostname());
        $this->assertEquals(123, $r->getTtl());
        $this->assertEquals('127.0.0.1', $r->getContent());

        // test object
        $o = $r->getObject();
        $this->doStandardObjectTests($r, $o);
        $this->assertObjectHasAttribute('content', $o);
        $this->assertEquals($r->getContent(), $o->content);
    }

    /** @dataProvider dataIpv4Values */
    public function testDNSARecordContentValidation($address, $isValid)
    {
        if (!$isValid) {
            $this->expectException(InvalidArgumentException::class);
        }

        new DnsARecord('test-123', 'example.com', 123, $address);

        $this->assertTrue($isValid);
    }

    public function testDNSCAARecord()
    {
        // test constructor
        $r = new DnsCAARecord('test-123', 'example.com', 123, '0 issue "ca.example.net"');
        $this->assertEquals('CAA', $r->getType());
        $this->assertEquals('test-123', $r->getId());
        $this->assertEquals('example.com', $r->getHostname());
        $this->assertEquals(123, $r->getTtl());
        $this->assertEquals('0 issue "ca.example.net"', $r->getContent());

        // test object
        $o = $r->getObject();
        $this->doStandardObjectTests($r, $o);
        $this->assertObjectHasAttribute('content', $o);
        $this->assertEquals($r->getContent(), $o->content);
    }

    public function testDNSCNAMERecord()
    {
        // test constructor
        $r = new DnsCNAMERecord('test-123', 'example.com', 123, 'valid.example.com');
        $this->assertEquals('CNAME', $r->getType());
        $this->assertEquals('test-123', $r->getId());
        $this->assertEquals('example.com', $r->getHostname());
        $this->assertEquals(123, $r->getTtl());
        $this->assertEquals('valid.example.com', $r->getContent());

        // test object
        $o = $r->getObject();
        $this->doStandardObjectTests($r, $o);
        $this->assertObjectHasAttribute('content', $o);
        $this->assertEquals($r->getContent(), $o->content);
    }

    /** @dataProvider dataHostnameValues */
    public function testDNSCNAMERecordContentValidation($address, $isValid)
    {
        if (!$isValid) {
            $this->expectException(InvalidArgumentException::class);
        }

        new DnsCNAMERecord('test-123', 'example.com', 123, $address);

        $this->assertTrue($isValid);
    }

    public function testMXRecord()
    {
        // test constructor
        $r = new DnsMXRecord('test-123', 'example.com', 123, 'mail.example.com', 5);
        $this->assertEquals('MX', $r->getType());
        $this->assertEquals('test-123', $r->getId());
        $this->assertEquals('example.com', $r->getHostname());
        $this->assertEquals(123, $r->getTtl());
        $this->assertEquals('mail.example.com', $r->getContent());
        $this->assertEquals(5, $r->getPriority());

        // test object
        $o = $r->getObject();
        $this->doStandardObjectTests($r, $o);
        $this->assertObjectHasAttribute('content', $o);
        $this->assertEquals($r->getContent(), $o->content);
        $this->assertObjectHasAttribute('priority', $o);
        $this->assertEquals($r->getPriority(), $o->priority);
    }

    /** @dataProvider dataHostnameValues */
    public function testDnsMXRecordContentValidation($address, $isValid)
    {
        if (!$isValid) {
            $this->expectException(InvalidArgumentException::class);
        }

        new DnsMXRecord('test-123', 'example.com', 123, $address, 10);

        $this->assertTrue($isValid);
    }

    /** @dataProvider dataUInt16Values */
    public function testDNSMXRecordPriorityValidation($value, $isValid)
    {
        if (!$isValid) {
            $this->expectException(InvalidArgumentException::class);
        }

        new DnsMXRecord('test-123', 'example.com', 123, 'mail.example.com', $value);

        $this->assertTrue($isValid);
    }

    public function testDNSNSRecord()
    {
        // test constructor
        $r = new DnsNSRecord('test-123', 'example.com', 123, 'ns1.example.com');
        $this->assertEquals('NS', $r->getType());
        $this->assertEquals('test-123', $r->getId());
        $this->assertEquals('example.com', $r->getHostname());
        $this->assertEquals(123, $r->getTtl());
        $this->assertEquals('ns1.example.com', $r->getContent());

        // test object
        $o = $r->getObject();
        $this->doStandardObjectTests($r, $o);
        $this->assertObjectHasAttribute('content', $o);
        $this->assertEquals($r->getContent(), $o->content);
    }

    /** @dataProvider dataHostnameValues */
    public function testDnsNSRecordContentValidation($value, $isValid)
    {
        if (!$isValid) {
            $this->expectException(InvalidArgumentException::class);
        }

        new DnsNSRecord('test-123', 'example.com', 123, $value, 10);

        $this->assertTrue($isValid);
    }

    public function testSOARecord()
    {
        // test constructor
        $r = new DnsSOARecord('test-123', 'example.com', 123, 'ns1.example.com hostmaster.example.com 123 456 789 012 345');
        $this->assertEquals('SOA', $r->getType());
        $this->assertEquals('test-123', $r->getId());
        $this->assertEquals('example.com', $r->getHostname());
        $this->assertEquals(123, $r->getTtl());
        $this->assertEquals('ns1.example.com hostmaster.example.com 123 456 789 012 345', $r->getContent());

        $this->assertEquals('ns1.example.com', $r->getMaster());
        $this->assertEquals('hostmaster.example.com', $r->getResponsible());
        $this->assertEquals(123, $r->getSerial());
        $this->assertEquals(456, $r->getRefresh());
        $this->assertEquals(789, $r->getRetry());
        $this->assertEquals(12, $r->getExpire());
        $this->assertEquals(345, $r->getMinimum());

        // test if updating individual fields updates the content
        $r->setMaster('ns2.example.com');
        $this->assertEquals('ns2.example.com hostmaster.example.com 123 456 789 12 345', $r->getContent());
        $r->setResponsible('dnsmaster.example.com');
        $this->assertEquals('ns2.example.com dnsmaster.example.com 123 456 789 12 345', $r->getContent());
        $r->setSerial(111);
        $this->assertEquals('ns2.example.com dnsmaster.example.com 111 456 789 12 345', $r->getContent());
        $r->setRefresh(222);
        $this->assertEquals('ns2.example.com dnsmaster.example.com 111 222 789 12 345', $r->getContent());
        $r->setRetry(333);
        $this->assertEquals('ns2.example.com dnsmaster.example.com 111 222 333 12 345', $r->getContent());
        $r->setExpire(444);
        $this->assertEquals('ns2.example.com dnsmaster.example.com 111 222 333 444 345', $r->getContent());
        $r->setMinimum(555);
        $this->assertEquals('ns2.example.com dnsmaster.example.com 111 222 333 444 555', $r->getContent());

        // test object
        $o = $r->getObject();
        $this->doStandardObjectTests($r, $o);
        $this->assertObjectHasAttribute('content', $o);
        $this->assertEquals($r->getContent(), $o->content);
    }

    public function testDNSSRVRecord()
    {
        // test constructor
        $r = new DnsSRVRecord('test-123', 'example.com', 123, '_sip', 'sipserver.example.com', '_tcp', 10, 5060, 0);
        $this->assertEquals('SRV', $r->getType());
        $this->assertEquals('test-123', $r->getId());
        $this->assertEquals('example.com', $r->getHostname());
        $this->assertEquals(123, $r->getTtl());

        $this->assertEquals('_sip', $r->getService());
        $this->assertEquals('sipserver.example.com', $r->getTarget());
        $this->assertEquals('_tcp', $r->getProtocol());
        $this->assertEquals(10, $r->getPriority());
        $this->assertEquals(5060, $r->getPort());
        $this->assertEquals(0, $r->getWeight());

        // test object
        $o = $r->getObject();
        $this->doStandardObjectTests($r, $o);
        $this->assertObjectHasAttribute('service', $o);
        $this->assertEquals($r->getService(), $o->service);
        $this->assertObjectHasAttribute('target', $o);
        $this->assertEquals($r->getTarget(), $o->target);
        $this->assertObjectHasAttribute('protocol', $o);
        $this->assertEquals($r->getProtocol(), $o->protocol);
        $this->assertObjectHasAttribute('priority', $o);
        $this->assertEquals($r->getPriority(), $o->priority);
        $this->assertObjectHasAttribute('port', $o);
        $this->assertEquals($r->getPort(), $o->port);
        $this->assertObjectHasAttribute('weight', $o);
        $this->assertEquals($r->getWeight(), $o->weight);
    }

    public function testDNSTXTRecord()
    {
        // test constructor
        $r = new DnsTXTRecord('test-123', 'example.com', 123, 'The quick brown fox jumps over the lazy dog');
        $this->assertEquals('TXT', $r->getType());
        $this->assertEquals('test-123', $r->getId());
        $this->assertEquals('example.com', $r->getHostname());
        $this->assertEquals(123, $r->getTtl());
        $this->assertEquals('The quick brown fox jumps over the lazy dog', $r->getContent());

        // test object
        $o = $r->getObject();
        $this->doStandardObjectTests($r, $o);
        $this->assertObjectHasAttribute('content', $o);
        $this->assertEquals($r->getContent(), $o->content);
    }

    /** @dataProvider dataHostnameValuesNoOrigin */
    public function testSOARecordMasterValidation($value, $isValid)
    {
        if (!$isValid) {
            $this->expectException(InvalidArgumentException::class);
        }

        new DnsSOARecord('test-123', 'example.com', 123, $value . ' dnsmaster.example.com 123 456 789 012 345');

        $this->assertTrue($isValid);
    }

    /** @dataProvider dataHostnameValuesNoOrigin */
    public function testSOARecordResponsibleValidation($value, $isValid)
    {
        if (!$isValid) {
            $this->expectException(InvalidArgumentException::class);
        }

        new DnsSOARecord('test-123', 'example.com', 123, 'ns1.example.com ' . $value . ' 123 456 789 012 345');

        $this->assertTrue($isValid);
    }

    /** @dataProvider dataUInt32Values */
    public function testSOARecordSerialValidation($value, $isValid)
    {
        if (!$isValid) {
            $this->expectException(InvalidArgumentException::class);
        }

        new DnsSOARecord('test-123', 'example.com', 123, 'ns1.example.com dnsmaster.example.com ' . $value . ' 456 789 012 345');

        $this->assertTrue($isValid);
    }

    /** @dataProvider dataUInt32Values */
    public function testSOARecordRefreshValidation($value, $isValid)
    {
        if (!$isValid) {
            $this->expectException(InvalidArgumentException::class);
        }

        new DnsSOARecord('test-123', 'example.com', 123, 'ns1.example.com dnsmaster.example.com 123 ' . $value . ' 789 012 345');

        $this->assertTrue($isValid);
    }

    /** @dataProvider dataUInt32Values */
    public function testSOARecordRetryValidation($value, $isValid)
    {
        if (!$isValid) {
            $this->expectException(InvalidArgumentException::class);
        }

        new DnsSOARecord('test-123', 'example.com', 123, 'ns1.example.com dnsmaster.example.com 123 456 ' . $value . ' 012 345');

        $this->assertTrue($isValid);
    }

    /** @dataProvider dataUInt32Values */
    public function testSOARecordExpireValidation($value, $isValid)
    {
        if (!$isValid) {
            $this->expectException(InvalidArgumentException::class);
        }

        new DnsSOARecord('test-123', 'example.com', 123, 'ns1.example.com dnsmaster.example.com 123 456 789 ' . $value . ' 345');

        $this->assertTrue($isValid);
    }

    /** @dataProvider dataUInt32Values */
    public function testSOARecordMinimalValidation($value, $isValid)
    {
        if (!$isValid) {
            $this->expectException(InvalidArgumentException::class);
        }

        new DnsSOARecord('test-123', 'example.com', 123, 'ns1.example.com dnsmaster.example.com 123 456 789 012 ' . $value);

        $this->assertTrue($isValid);
    }

    public function dataIpv4Values()
    {
        return [
            ['', false],
            ['127.0.0.1', true],
            ['127.0.0.256', false],
            ['0.0.0.0', true],
            ['::1', false],
            ['banana', false],
        ];
    }

    public function dataIpv6Values()
    {
        return [
            ['', false],
            ['::', true],
            ['::1', true],
            ['2001:0db8:85a3:0000:0000:8a2e:0370:7334', true],
            ['2001:0db8:85a3::8a2e:0370:7334', true],
            ['127.0.0.1', false],
            ['banana', false],
        ];
    }

    public function dataHostnameValues()
    {
        return [
            ['', true],
            ['@', true],
            ['example', true],
            ['example.com', true],
            ['example.com ', false],
            [' example.com', false],
            ['127.0.0.1', true],
            ['2001:0db8:85a3:0000:0000:8a2e:0370:7334', false],
            ['yellow-banana.example.com', true],
            ['brown_banana.example.com', false],
            ['_banana.example.com', true],
            ['__banana.example.com', false],
            ['-banana.example.com', false],
        ];
    }

    public function dataHostnameValuesNoOrigin()
    {
        return [
            ['example', true],
            ['example.com', true],
            ['example.com ', false],
            [' example.com', false],
            ['127.0.0.1', true],
            ['2001:0db8:85a3:0000:0000:8a2e:0370:7334', false],
            ['yellow-banana.example.com', true],
            ['brown_banana.example.com', false],
            ['_banana.example.com', true],
            ['__banana.example.com', false],
            ['-banana.example.com', false],
        ];
    }

    public function dataUInt16Values()
    {
        return [
            [0, true],
            [-1, false],
            [65535, true],
            [65536, false],
        ];
    }

    public function dataUInt32Values()
    {
        return [
            [0, true],
            [-1, false],
            [2147483647, true],
            [2147483648, false],
        ];
    }
}

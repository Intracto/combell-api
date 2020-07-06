<?php

namespace Test\Command\MysqlDatabases;

use PHPUnit\Framework\TestCase;
use TomCan\CombellApi\Adapter\AdapterInterface;
use TomCan\CombellApi\Common\HmacGenerator;
use TomCan\CombellApi\Common\Api;
use TomCan\CombellApi\Command\LinuxHostings\GetLinuxHosting;
use TomCan\CombellApi\Structure\LinuxHostings\LinuxHosting;
use TomCan\CombellApi\Structure\LinuxHostings\Site;
use TomCan\CombellApi\Structure\LinuxHostings\HostHeader;

final class GetLinuxHostingTest extends TestCase
{
    public function testGetLinuxHosting(): void
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
                    'domain_name' => 'example.com',
                    'servicepack_id' => '1001',
                    'max_webspace_size' => 150000,
                    'max_size' => 150000,
                    'webspace_usage' => 5842,
                    'actual_size' => 5842,
                    'ip' => '127.42.42.42',
                    'ip_type' => 'shared',
                    'ftp_username' => 'examplecom@examplecom',
                    'ssh_host' => 'ssh001.webhosting.be',
                    'ssh_username' => 'examplecom',
                    'php_version' => '7.4',
                    'sites' => [
                        (object) [
                            'name' => 'example.com',
                            'path' => '/www',
                            'host_headers' => [
                                (object) [
                                    'name' => 'example.com',
                                    'enabled' => true,
                                ],
                                (object) [
                                    'name' => 'www.example.com',
                                    'enabled' => true,
                                ],
                                (object) [
                                    'name' => 'examplecom.webhosting.be',
                                    'enabled' => true,
                                ],
                            ],
                            'ssl_enabled' => true,
                            'https_redirect_enabled' => true,
                            'http2_enabled' => false,
                        ],
                    ],
                    'mysql_database_names' => [
                        'ID12345_examplecom',
                    ],
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
            ->with('GET', 'https://api.combell.com/v2/linuxhostings/example.com', $headers, '')
            ->willReturn($returnValue);

        $hmacGeneratorStub = $this->createMock(HmacGenerator::class);
        $hmacGeneratorStub->method('getHeader')
            ->willReturn('hmac mocked');
        $api = new Api($adapterStub, $hmacGeneratorStub);

        $cmd = new GetLinuxHosting('example.com');
        /** @var LinuxHosting $linuxHosting */
        $linuxHosting = $api->executeCommand($cmd);

        $this->assertInstanceOf(LinuxHosting::class, $linuxHosting);
        $this->assertEquals('example.com', $linuxHosting->getDomainName());
        $this->assertEquals(1001, $linuxHosting->getServicepackId());
        $this->assertEquals(150000, $linuxHosting->getMaxWebspaceSize());
        $this->assertEquals(150000, $linuxHosting->getMaxSize());
        $this->assertEquals(5842, $linuxHosting->getWebspaceUsage());
        $this->assertEquals(5842, $linuxHosting->getActualSize());
        $this->assertEquals('127.42.42.42', $linuxHosting->getIp());
        $this->assertEquals('shared', $linuxHosting->getIpType());
        $this->assertEquals('ssh001.webhosting.be', $linuxHosting->getSshHost());
        $this->assertEquals('examplecom.webhosting.be', $linuxHosting->getFtpHost());
        $this->assertEquals('examplecom@examplecom', $linuxHosting->getFtpUserName());
        $this->assertEquals('examplecom', $linuxHosting->getSshUserName());
        $this->assertEquals('7.4', $linuxHosting->getPhpVersion());
        $this->assertCount(1, $linuxHosting->getMysqlDatabaseNames());
        $this->assertEquals('ID12345_examplecom', $linuxHosting->getMysqlDatabaseNames()[0]);
        /** @var Site[] $sites */
        $sites = $linuxHosting->getSites();
        $this->assertCount(1, $sites);
        $this->assertEquals('example.com', $sites[0]->getName());
        $this->assertEquals('/www', $sites[0]->getPath());
        $this->assertTrue($sites[0]->isSslEnabled());
        $this->assertTrue($sites[0]->isHttpsRedirectEnabled());
        $this->assertFalse($sites[0]->isHttp2Enabled());
        /** @var Hostheader[] $hostHeaders */
        $hostHeaders = $sites[0]->getHostHeaders();
        $this->assertCount(3, $hostHeaders);
        $this->assertEquals('examplecom.webhosting.be', $hostHeaders[2]->getName());
        $this->assertTrue($hostHeaders[2]->isEnabled());
    }
}

<?php

namespace Test\Command\MysqlDatabases;

use PHPUnit\Framework\TestCase;
use TomCan\CombellApi\Adapter\AdapterInterface;
use TomCan\CombellApi\Common\HmacGenerator;
use TomCan\CombellApi\Common\Api;
use TomCan\CombellApi\Command\WindowsHostings\GetWindowsHosting;
use TomCan\CombellApi\Structure\WindowsHostings\WindowsHosting;
use TomCan\CombellApi\Structure\WindowsHostings\Site;
use TomCan\CombellApi\Structure\WindowsHostings\Binding;

final class GetWindowsHostingTest extends TestCase
{
    public function testGetWindowsHosting(): void
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
                    'domain_name' => 'example.com',
                    'servicepack_id' => '1001',
                    'max_size' => 150000,
                    'actual_size' => 5842,
                    'ip' => '127.42.42.42',
                    'ip_type' => 'shared',
                    'ftp_username' => 'examplecom@examplecom',
                    'application_pool' => (object) [
                        'runtime' => 'v4.0',
                        'pipeline_mode' => 'Integrated',
                        'installed_net_core_runtimes' => [
                            '2.2.7',
                            '3.0.0',
                        ]
                    ],
                    'sites' => [
                        (object) [
                            'name' => 'example.com',
                            'path' => '/www',
                            'bindings' => [
                                (object) [
                                    'protocol' => 'http',
                                    'host_name' => 'example.com',
                                    'ip_address' => '1.2.3.4',
                                    'port' => 80,
                                    'cert_thumbprint' => null,
                                    'ssl_enabled' => false,
                                ],
                                (object) [
                                    'protocol' => 'http',
                                    'host_name' => 'www.example.com',
                                    'ip_address' => '1.2.3.4',
                                    'port' => 80,
                                    'cert_thumbprint' => null,
                                    'ssl_enabled' => false,
                                ],
                                (object) [
                                    'protocol' => 'http',
                                    'host_name' => 'examplecom.webhosting.be',
                                    'ip_address' => '1.2.3.4',
                                    'port' => 80,
                                    'cert_thumbprint' => null,
                                    'ssl_enabled' => false,
                                ],
                                (object) [
                                    'protocol' => 'https',
                                    'host_name' => 'secure.example.com',
                                    'ip_address' => '1.2.3.4',
                                    'port' => 443,
                                    'cert_thumbprint' => '01:23:45:67:89:AB:CD:EF',
                                    'ssl_enabled' => true,
                                ],
                            ],
                        ],
                    ],
                    'mssql_database_names' => [
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
            ->with('GET', 'https://api.combell.com/v2/windowshostings/example.com', $headers, '')
            ->willReturn($returnValue);

        $hmacGeneratorStub = $this->createMock(HmacGenerator::class);
        $hmacGeneratorStub->method('getHeader')
            ->willReturn('hmac mocked');
        $api = new Api($adapterStub, $hmacGeneratorStub);

        $cmd = new GetWindowsHosting('example.com');
        /** @var WindowsHosting $windowsHosting */
        $windowsHosting = $api->executeCommand($cmd);

        $this->assertInstanceOf(WindowsHosting::class, $windowsHosting);
        $this->assertEquals('example.com', $windowsHosting->getDomainName());
        $this->assertEquals(1001, $windowsHosting->getServicepackId());
        $this->assertEquals(150000, $windowsHosting->getMaxSize());
        $this->assertEquals(5842, $windowsHosting->getActualSize());
        $this->assertEquals('127.42.42.42', $windowsHosting->getIp());
        $this->assertEquals('shared', $windowsHosting->getIpType());
        $this->assertEquals('windowsftp.webhosting.be', $windowsHosting->getFtpHost());
        $this->assertEquals('examplecom@examplecom', $windowsHosting->getFtpUserName());
        $this->assertEquals('v4.0 Integrated', $windowsHosting->getFrameworkVersion());
        $this->assertCount(1, $windowsHosting->getMssqlDatabaseNames());
        $this->assertEquals('ID12345_examplecom', $windowsHosting->getMssqlDatabaseNames()[0]);
        /** @var Site[] $sites */
        $sites = $windowsHosting->getSites();
        $this->assertCount(1, $sites);
        $this->assertEquals('example.com', $sites[0]->getName());
        $this->assertEquals('/www', $sites[0]->getPath());

        /** @var Binding[] $bindings */
        $bindings = $sites[0]->getBindings();
        $this->assertCount(4, $bindings);
        $this->assertEquals('examplecom.webhosting.be', $bindings[2]->getName());
        $this->assertEquals('http', $bindings[2]->getProtocol());
        $this->assertEquals('https', $bindings[3]->getProtocol());
        $this->assertEquals(443, $bindings[3]->getPort());
        $this->assertTrue($bindings[3]->getSslEnabled());
        $this->assertEquals('01:23:45:67:89:AB:CD:EF', $bindings[3]->getSslFingerprint());
    }
}

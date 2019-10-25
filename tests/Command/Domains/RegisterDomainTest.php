<?php

namespace Test\Command\Dns;

use PHPUnit\Framework\TestCase;
use TomCan\CombellApi\Adapter\AdapterInterface;
use TomCan\CombellApi\Common\HmacGenerator;
use TomCan\CombellApi\Common\Api;
use TomCan\CombellApi\Command\Domains\RegisterDomain;

final class RegisterDomainTest extends TestCase
{
    public function testRegisterDomain(): void
    {
        $returnValue = [
            'status' => 202,
            'headers' => [
                'Content-Length' => ['0'],
                'Location' => ['/v2/provisioningjobs/12345678-90ab-cdef-1234-567890abcdef'],
                'Retry-After' => ['10'],
                'X-RateLimit-Limit' => ['100'],
                'X-RateLimit-Usage' => ['1'],
                'X-RateLimit-Remaining' => ['99'],
                'X-RateLimit-Reset' => ['60'],
                'Date' => ['Sat, 02 Feb 2019 20:23:35 GMT'],
            ],
            'body' => '',
        ];

        $adapterStub = $this->createMock(AdapterInterface::class);
        $headers = [
            'Authorization' => 'hmac mocked',
            'Accept' => 'application/json',
            'Content-type' => 'application/json',
        ];
        $adapterStub->method('call')
            ->with('POST', 'https://api.combell.com/v2/domains/registrations', $headers, '{"domain_name":"example.com","name_servers":["ns3.combell.net","ns4.combell.net"]}')
            ->willReturn($returnValue);

        $hmacGeneratorStub = $this->createMock(HmacGenerator::class);
        $hmacGeneratorStub->method('getHeader')
            ->willReturn('hmac mocked');
        $api = new Api($adapterStub, $hmacGeneratorStub);

        $cmd = new RegisterDomain(
            'example.com',
            ['ns3.combell.net', 'ns4.combell.net']
        );

        $response = $api->executeCommand($cmd);
        $this->assertEquals($response, '12345678-90ab-cdef-1234-567890abcdef');

        $this->assertEquals('202', $api->getResponseCode());
    }
}

<?php

namespace Test\Command\ProvisioningJobs;

use PHPUnit\Framework\TestCase;
use TomCan\CombellApi\Adapter\AdapterInterface;
use TomCan\CombellApi\Common\HmacGenerator;
use TomCan\CombellApi\Common\Api;
use TomCan\CombellApi\Command\ProvisioningJobs\GetProvisioningJob;
use TomCan\CombellApi\Structure\ProvisioningJobs\ProvisioningJob;

final class GetProvisioningJobTest extends TestCase
{
    public function testGetOngoingProvisionJob(): void
    {
        $returnValue = [
            'status' => 200,
            'headers' => [
                'Content-Type' => ['application/json; charset=utf-8'],
                'x-ratelimit-limit' => ['100'],
                'x-ratelimit-usage' => ['1'],
                'x-ratelimit-remaining' => ['99'],
                'x-ratelimit-reset' => ['60'],
                'Date' => ['Sat, 02 Feb 2019 20:23:35 GMT'],
            ],
            'body' => json_encode(
                (object) [
                    'id' => '12345678-90ab-cdef-1234-567890abcde0',
                    'status' => 'ongoing',
                    'completion' => (object) ['estimate' => '2019-10-20T18:43:54.007'],
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
            ->with('GET', 'https://api.combell.com/v2/provisioningjobs/12345678-90ab-cdef-1234-567890abcde0', $headers, '')
            ->willReturn($returnValue);

        $hmacGeneratorStub = $this->createMock(HmacGenerator::class);
        $hmacGeneratorStub->method('getHeader')
            ->willReturn('hmac mocked');
        $api = new Api($adapterStub, $hmacGeneratorStub);

        $cmd = new GetProvisioningJob('12345678-90ab-cdef-1234-567890abcde0');
        /** @var ProvisioningJob $provisionJob */
        $provisionJob = $api->executeCommand($cmd);

        $this->assertInstanceOf(ProvisioningJob::class, $provisionJob);
        $this->assertEquals($provisionJob->getId(), '12345678-90ab-cdef-1234-567890abcde0');
        $this->assertEquals($provisionJob->getStatus(), 'ongoing');
        $this->assertEquals($provisionJob->getEstimate()->format('Y-m-d H:i:s'), '2019-10-20 18:43:54');
        $this->assertEquals($provisionJob->getResourceLinks(), []);
    }

    public function testGetFailedProvisionJob(): void
    {
        $returnValue = [
            'status' => 200,
            'headers' => [
                'Content-Type' => ['application/json; charset=utf-8'],
                'x-ratelimit-limit' => ['100'],
                'x-ratelimit-usage' => ['1'],
                'x-ratelimit-remaining' => ['99'],
                'x-ratelimit-reset' => ['60'],
                'Date' => ['Sat, 02 Feb 2019 20:23:35 GMT'],
            ],
            'body' => json_encode(
                (object) [
                    'id' => '12345678-90ab-cdef-1234-567890abcde1',
                    'status' => 'failed',
                    'completion' => (object) ['estimate' => '2019-10-20T14:48:24.7446134Z'],
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
            ->with('GET', 'https://api.combell.com/v2/provisioningjobs/12345678-90ab-cdef-1234-567890abcde1', $headers, '')
            ->willReturn($returnValue);

        $hmacGeneratorStub = $this->createMock(HmacGenerator::class);
        $hmacGeneratorStub->method('getHeader')
            ->willReturn('hmac mocked');
        $api = new Api($adapterStub, $hmacGeneratorStub);

        $cmd = new GetProvisioningJob('12345678-90ab-cdef-1234-567890abcde1');
        /** @var ProvisioningJob $provisionJob */
        $provisionJob = $api->executeCommand($cmd);

        $this->assertInstanceOf(ProvisioningJob::class, $provisionJob);
        $this->assertEquals($provisionJob->getId(), '12345678-90ab-cdef-1234-567890abcde1');
        $this->assertEquals($provisionJob->getStatus(), 'failed');
        $this->assertEquals($provisionJob->getEstimate()->format('Y-m-d H:i:s'), '2019-10-20 14:48:24');
        $this->assertEquals($provisionJob->getResourceLinks(), []);
    }

    public function testGetSuccessProvisionJob(): void
    {
        $returnValue = [
            'status' => 201,
            'headers' => [
                'Content-Type' => ['application/json; charset=utf-8'],
                'Location' => ['/v2/mysqldatabases/ID909001_tests'],
                'x-ratelimit-limit' => ['100'],
                'x-ratelimit-usage' => ['1'],
                'x-ratelimit-remaining' => ['99'],
                'x-ratelimit-reset' => ['60'],
                'Date' => ['Sat, 02 Feb 2019 20:23:35 GMT'],
            ],
            'body' => json_encode(
                (object) [
                    'id' => '12345678-90ab-cdef-1234-567890abcde2',
                    'resource_links' => [
                        '/v2/mysqldatabases/ID909001_tests',
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
            ->with('GET', 'https://api.combell.com/v2/provisioningjobs/12345678-90ab-cdef-1234-567890abcde2', $headers, '')
            ->willReturn($returnValue);

        $hmacGeneratorStub = $this->createMock(HmacGenerator::class);
        $hmacGeneratorStub->method('getHeader')
            ->willReturn('hmac mocked');
        $api = new Api($adapterStub, $hmacGeneratorStub);

        $cmd = new GetProvisioningJob('12345678-90ab-cdef-1234-567890abcde2');
        /** @var ProvisioningJob $provisionJob */
        $provisionJob = $api->executeCommand($cmd);

        $this->assertInstanceOf(ProvisioningJob::class, $provisionJob);
        $this->assertEquals($provisionJob->getId(), '12345678-90ab-cdef-1234-567890abcde2');
        $this->assertEquals($provisionJob->getStatus(), 'finished');
        $this->assertEquals($provisionJob->getEstimate(), null);
        $this->assertCount(1, $provisionJob->getResourceLinks());
        $this->assertEquals($provisionJob->getResourceLinks()[0]->getId(), 'ID909001_tests');
        $this->assertEquals($provisionJob->getResourceLinks()[0]->getType(), 'mysqldatabases');
    }
}

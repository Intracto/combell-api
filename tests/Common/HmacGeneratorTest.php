<?php

namespace Test\Command\Common;

use PHPUnit\Framework\TestCase;
use Symfony\Bridge\PhpUnit\ClockMock;
use TomCan\CombellApi\Common\HmacGenerator;
use TomCan\CombellApi\Command\Accounts\ListAccounts;

/** @group time-sensitive */
final class HmacGeneratorTest extends TestCase
{
    public function testHmacGenerator(): void
    {
        ClockMock::withClockMock('1239363000');
        ClockMock::register(HmacGenerator::class);

        $hmacGenerator = new HmacGenerator('secretkey', 'secretpass');
        [$apiKey, $hmac, $nonce, $timestamp] = explode(':', $hmacGenerator->getHeader(new ListAccounts()));
        $this->assertEquals('hmac secretkey', $apiKey);
        $this->assertEquals('1239363000', $timestamp);
        $this->assertStringStartsWith('combell_api', $nonce);
        $this->assertEquals(34, strlen($nonce));
        $this->assertEquals(44, strlen($hmac));
    }
}

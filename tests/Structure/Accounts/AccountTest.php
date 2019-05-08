<?php

namespace Test\Command\Accounts;

use PHPUnit\Framework\TestCase;

use TomCan\CombellApi\Structure\Accounts\Account;

final class AccountTest extends TestCase
{
    /** @var Account */
    private $account;

    public function setUp(): void
    {
        parent::setUp();

        $this->account = new Account(10, 'test 1');
    }

    public function testInitialisation(): void
    {
        $this->assertEquals(10, $this->account->getId());
        $this->assertEquals('test 1', $this->account->getIdentifier());
    }

    public function testSetters(): void
    {
        $this->account->setId(20);
        $this->assertEquals(20, $this->account->getId());

        $this->account->setIdentifier('test 2');
        $this->assertEquals('test 2', $this->account->getIdentifier());
    }
}

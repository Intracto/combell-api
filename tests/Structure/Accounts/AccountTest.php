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

        $this->account = new Account(10, 'test 1', 1001);

        $this->account->addAddon(1020);
        $this->account->addAddon(1030);
    }

    public function testInitialisation(): void
    {
        $this->assertEquals(10, $this->account->getId());
        $this->assertEquals('test 1', $this->account->getIdentifier());
        $this->assertEquals(1001, $this->account->getServicepackId());
        $this->assertCount(2, $this->account->getAddons());
        $this->assertEquals(1020, $this->account->getAddons()[0]);
        $this->assertEquals(1030, $this->account->getAddons()[1]);
    }

    public function testSetters(): void
    {
        $this->account->setId(20);
        $this->assertEquals(20, $this->account->getId());

        $this->account->setIdentifier('test 2');
        $this->assertEquals('test 2', $this->account->getIdentifier());

        $this->account->setServicepackId(1002);
        $this->assertEquals(1002, $this->account->getServicepackId());

        $this->account->addAddon(1040);
        $this->account->addAddon(1050);
        $this->assertCount(4, $this->account->getAddons());
        $this->assertEquals(1040, $this->account->getAddons()[2]);
        $this->assertEquals(1050, $this->account->getAddons()[3]);
    }
}

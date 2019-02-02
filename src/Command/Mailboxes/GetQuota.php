<?php

namespace TomCan\CombellApi\Command\Mailboxes;

use TomCan\CombellApi\Command\AbstractCommand;

class GetQuota extends AbstractCommand
{
    private $domainName;

    public function __construct(string $domainName)
    {
        parent::__construct('get', '/v2/mailboxes/{domainname}/quota');

        $this->domainName = $domainName;
    }

    public function prepare(): void
    {
        $this->setEndPoint('/v2/mailboxes/' . $this->domainName . '/quota');
    }

    public function getDomainName(): string
    {
        return $this->domainName;
    }

    public function setDomainName(string $domainName): void
    {
        $this->domainName = $domainName;
    }
}

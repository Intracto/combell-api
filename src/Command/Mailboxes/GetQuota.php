<?php

namespace TomCan\CombellApi\Command\Mailboxes;

use TomCan\CombellApi\Command\AbstractCommand;

class GetQuota extends AbstractCommand
{
    private $domainname;

    public function __construct(string $domainname)
    {
        parent::__construct('get', '/v2/mailboxes/{domainname}/quota');

        $this->domainname = $domainname;
    }

    public function prepare(): void
    {
        $this->setEndPoint('/v2/mailboxes/' . $this->domainname . '/quota');
    }

    public function getDomainname(): string
    {
        return $this->domainname;
    }

    public function setDomainname(string $domainname): void
    {
        $this->domainname = $domainname;
    }
}

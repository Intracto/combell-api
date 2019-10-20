<?php

namespace TomCan\CombellApi\Command\Mailboxes;

use TomCan\CombellApi\Command\AbstractCommand;
use TomCan\CombellApi\Structure\Mailbox\Mailbox;

class GetMailboxes extends AbstractCommand
{
    private $domainName;

    public function __construct(string $domainName)
    {
        parent::__construct('get', '/v2/mailboxes');

        $this->domainName = $domainName;
    }

    public function prepare(): void
    {
        $this->setEndPoint('/v2/mailboxes/?domain_name=' . $this->domainName);
    }

    public function processResponse(array $response)
    {
        $mailboxes = [];
        foreach ($response['body'] as $mailbox) {
            $mailboxes[] = new Mailbox(
                $mailbox->name,
                $mailbox->max_size,
                $mailbox->actual_size
            );
        }

        return $mailboxes;
    }
}

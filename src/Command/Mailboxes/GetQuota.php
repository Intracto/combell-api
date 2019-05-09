<?php

namespace TomCan\CombellApi\Command\Mailboxes;

use TomCan\CombellApi\Command\AbstractCommand;

use TomCan\CombellApi\Structure\Mailbox\Quota;

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

    public function processResponse(array $response)
    {
        $quotas = [];
        foreach ($response['body'] as $quota) {
            $quotas[] = new Quota(
                $quota->size,
                $quota->account_id
            );
        }

        return $quotas;
    }
}

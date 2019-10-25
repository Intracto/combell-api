<?php

namespace TomCan\CombellApi\Command\Mailboxes;

use TomCan\CombellApi\Command\AbstractCommand;

class CreateMailbox extends AbstractCommand
{
    private $domainName;
    private $email;
    private $password;
    private $accountId;

    public function __construct(string $domainName, string $email, string $password, int $accountId)
    {
        parent::__construct('post', '/v2/mailboxes/{domainName}');

        $this->domainName = $domainName;
        $this->email = $email;
        $this->password = $password;
        $this->accountId = $accountId;
    }

    public function prepare(): void
    {
        $this->setEndPoint('/v2/mailboxes/'.$this->domainName);

        $obj = new \stdClass();
        $obj->email = $this->email;
        $obj->password = $this->password;
        $obj->account_id = $this->accountId;

        $this->setBody((string) json_encode($obj));
    }

    public function processResponse(array $response)
    {
    }
}

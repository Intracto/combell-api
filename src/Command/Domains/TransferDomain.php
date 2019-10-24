<?php

namespace TomCan\CombellApi\Command\Domains;

use TomCan\CombellApi\Command\AbstractCommand;

class TransferDomain extends AbstractCommand
{
    private $domainName;
    private $authCode;

    public function __construct(string $domainName, string $authCode)
    {
        parent::__construct('post', '/v2/domains/transfers');

        $this->domainName = $domainName;
        $this->authCode = $authCode;
    }

    public function prepare(): void
    {
        $obj = new \stdClass();
        $obj->domain_name = $this->domainName;
        $obj->auth_code = $this->authCode;

        $this->setBody((string) json_encode($obj));
    }

    public function processResponse(array $response)
    {
    }
}

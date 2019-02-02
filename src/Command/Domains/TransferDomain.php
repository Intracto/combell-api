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

        $this->setDomainName($domainName);
        $this->setAuthCode($authCode);
    }

    public function prepare(): void
    {
        $obj = new \stdClass();
        $obj->domain_name = $this->domainName;
        $obj->auth_code = $this->authCode;

        $this->setBody((string) json_encode($obj));
    }

    public function getDomainName(): string
    {
        return $this->domainName;
    }

    public function setDomainName(string $domainName): void
    {
        $this->domainName = $domainName;
    }

    public function getAuthCode(): string
    {
        return $this->authCode;
    }

    public function setAuthCode(string $authCode): void
    {
        $this->authCode = $authCode;
    }
}

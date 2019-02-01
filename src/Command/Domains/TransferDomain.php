<?php

namespace TomCan\CombellApi\Command\Domains;

use TomCan\CombellApi\Command\AbstractCommand;

class TransferDomain extends AbstractCommand
{
    private $domainname;
    private $authcode;

    public function __construct(string $domainname, string $authcode)
    {
        parent::__construct('post', '/v2/domains/transfers');

        $this->setDomainname($domainname);
        $this->setAuthcode($authcode);
    }

    public function prepare(): void
    {
        $obj = new \stdClass();
        $obj->domain_name = $this->domainname;
        $obj->auth_code = $this->authcode;

        $this->setBody((string) json_encode($obj));
    }

    public function getDomainname(): string
    {
        return $this->domainname;
    }

    public function setDomainname(string $domainname): void
    {
        $this->domainname = $domainname;
    }

    public function getAuthcode(): string
    {
        return $this->authcode;
    }

    public function setAuthcode(string $authcode): void
    {
        $this->authcode = $authcode;
    }
}

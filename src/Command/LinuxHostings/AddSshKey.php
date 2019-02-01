<?php

namespace TomCan\CombellApi\Command\LinuxHostings;

use TomCan\CombellApi\Command\AbstractCommand;

class AddSshKey extends AbstractCommand
{
    private $domainname;
    private $pubkey;

    public function __construct(string $domainname, string $pubkey)
    {
        parent::__construct('post', '/v2/linuxhostings/{domainname}/ssh/keys');

        $this->setDomainname($domainname);
        $this->setPubkey($pubkey);
    }

    public function prepare(): void
    {
        $this->setEndPoint('/v2/linuxhostings/' . $this->domainname . '/ssh/keys');

        $obj = new \stdClass();
        $obj->public_key = $this->pubkey;

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

    public function getPubkey(): string
    {
        return $this->pubkey;
    }

    public function setPubkey(string $pubkey): void
    {
        $this->pubkey = $pubkey;
    }
}

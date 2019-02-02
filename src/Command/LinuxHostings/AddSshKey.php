<?php

namespace TomCan\CombellApi\Command\LinuxHostings;

use TomCan\CombellApi\Command\AbstractCommand;

class AddSshKey extends AbstractCommand
{
    private $domainName;
    private $pubKey;

    public function __construct(string $domainName, string $pubKey)
    {
        parent::__construct('post', '/v2/linuxhostings/{domainname}/ssh/keys');

        $this->setDomainName($domainName);
        $this->setPubKey($pubKey);
    }

    public function prepare(): void
    {
        $this->setEndPoint('/v2/linuxhostings/' . $this->domainName . '/ssh/keys');

        $obj = new \stdClass();
        $obj->public_key = $this->pubKey;

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

    public function getPubKey(): string
    {
        return $this->pubKey;
    }

    public function setPubKey(string $pubKey): void
    {
        $this->pubKey = $pubKey;
    }
}

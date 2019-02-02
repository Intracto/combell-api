<?php

namespace TomCan\CombellApi\Command\Mailboxes;

use TomCan\CombellApi\Command\AbstractCommand;

class CreateMailbox extends AbstractCommand
{
    private $domainName;
    private $email;
    private $password;

    public function __construct(string $domainName, string $email, string $password)
    {
        parent::__construct('post', '/v2/mailboxes/{domainname}');

        $this->setDomainName($domainName);
        $this->setEmail($email);
        $this->setPassword($password);
    }

    public function prepare(): void
    {
        $this->setEndPoint('/v2/mailboxes/' . $this->domainName);

        $obj = new \stdClass();
        $obj->email = $this->email;
        $obj->password = $this->password;

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

    public function getEmail(): string
    {
        return $this->email;
    }

    public function setEmail(string $email): void
    {
        $this->email = $email;
    }

    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): void
    {
        $this->password = $password;
    }
}

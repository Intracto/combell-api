<?php

namespace TomCan\CombellApi\Command\Mailboxes;

use TomCan\CombellApi\Command\AbstractCommand;

class CreateMailbox extends AbstractCommand
{
    private $domainname;
    private $email;
    private $password;

    public function __construct(string $domainname, string $email, string $password)
    {
        parent::__construct('post', '/v2/mailboxes/{domainname}');

        $this->setDomainname($domainname);
        $this->setEmail($email);
        $this->setPassword($password);
    }

    public function prepare(): void
    {
        $this->setEndPoint('/v2/mailboxes/' . $this->domainname);

        $obj = new \stdClass();
        $obj->email = $this->email;
        $obj->password = $this->password;

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

<?php

namespace TomCan\CombellApi\Command\Mailboxes;

use TomCan\CombellApi\Command\AbstractCommand;

class CreateMailbox extends AbstractCommand
{

    private $domainname;
    private $email;
    private $password;

    public function __construct($domainname, $email, $password)
    {
        parent::__construct("post", "/v2/mailboxes/{domainname}");

        $this->setDomainname($domainname);
        $this->setEmail($email);
        $this->setPassword($password);
    }

    public function prepare()
    {

        $this->setEndPoint("/v2/mailboxes/".$this->domainname);

        $obj = new \stdClass();
        $obj->email = $this->email;
        $obj->password = $this->password;

        $this->setBody(
            json_encode($obj)
        );

    }

    /**
     * @return mixed
     */
    public function getDomainname()
    {
        return $this->domainname;
    }

    /**
     * @param mixed $domainname
     */
    public function setDomainname($domainname)
    {
        $this->domainname = $domainname;
    }

    /**
     * @return mixed
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @param mixed $email
     */
    public function setEmail($email)
    {
        $this->email = $email;
    }

    /**
     * @return mixed
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * @param mixed $password
     */
    public function setPassword($password)
    {
        $this->password = $password;
    }

}
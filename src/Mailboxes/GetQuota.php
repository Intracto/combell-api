<?php

namespace TomCan\CombellApi\Mailboxes;

use TomCan\CombellApi\Common\AbstractCommand;

class GetQuota extends AbstractCommand
{

    /**
     * @var string
     */
    private $domainname;

    public function __construct($domainname)
    {
        parent::__construct("get", "/v2/mailboxes/{domainname}/quota");

        $this->domainname = $domainname;

    }

    public function prepare()
    {
        $this->setEndPoint("/v2/mailboxes/" . $this->domainname . "/quota");
    }

    /**
     * @return string
     */
    public function getDomainname()
    {
        return $this->domainname;
    }

    /**
     * @param string $domainname
     */
    public function setDomainname($domainname)
    {
        $this->domainname = $domainname;
    }

}
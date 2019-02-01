<?php

namespace TomCan\CombellApi\Command\LinuxHostings;

use TomCan\CombellApi\Command\AbstractCommand;
use TomCan\CombellApi\Structure\LinuxHostings\LinuxHosting;

class GetLinuxHosting extends AbstractCommand
{
    private $domainname;

    public function __construct($domainname)
    {
        parent::__construct('get', '/v2/linuxhostings');

        $this->domainname = $domainname;
    }

    public function prepare(): void
    {
        $this->setEndPoint('/v2/linuxhostings/' . $this->domainname);
    }

    public function getDomainname(): string
    {
        return $this->domainname;
    }

    public function setDomainname(string $domainname): void
    {
        $this->domainname = $domainname;
    }

    public function processResponse($response)
    {
        $h = $response['body'];
        $response['response'] = new LinuxHosting(
            $h->domain_name,
            $h->servicepack_id,
            $h->max_webspace_size,
            $h->max_size,
            $h->webspace_usage,
            $h->actual_size,
            $h->ip,
            $h->ip_type,
            $h->ssh_host,
            $h->ftp_username,
            $h->ssh_username
        );

        return $response;
    }
}

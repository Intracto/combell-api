<?php

namespace TomCan\CombellApi\Command\LinuxHostings;

use TomCan\CombellApi\Command\AbstractCommand;
use TomCan\CombellApi\Structure\LinuxHostings\LinuxHosting;

class GetLinuxHosting extends AbstractCommand
{
    private $domainName;

    public function __construct(string $domainName)
    {
        parent::__construct('get', '/v2/linuxhostings');

        $this->domainName = $domainName;
    }

    public function prepare(): void
    {
        $this->setEndPoint('/v2/linuxhostings/' . $this->domainName);
    }

    public function getDomainName(): string
    {
        return $this->domainName;
    }

    public function setDomainName(string $domainName): void
    {
        $this->domainName = $domainName;
    }

    public function processResponse(array $response)
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

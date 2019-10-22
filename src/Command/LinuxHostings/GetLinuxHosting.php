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

    public function processResponse(array $response)
    {
        $linuxHosting = $response['body'];

        return new LinuxHosting(
            $linuxHosting->domain_name,
            $linuxHosting->servicepack_id,
            $linuxHosting->max_webspace_size,
            $linuxHosting->max_size,
            $linuxHosting->webspace_usage,
            $linuxHosting->actual_size,
            $linuxHosting->ip,
            $linuxHosting->ip_type,
            $linuxHosting->ssh_host,
            $linuxHosting->ftp_username,
            $linuxHosting->ssh_username
        );
    }
}

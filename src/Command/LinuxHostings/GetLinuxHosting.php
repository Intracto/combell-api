<?php

namespace TomCan\CombellApi\Command\LinuxHostings;

use TomCan\CombellApi\Command\AbstractCommand;
use TomCan\CombellApi\Structure\LinuxHostings\HostHeader;
use TomCan\CombellApi\Structure\LinuxHostings\LinuxHosting;
use TomCan\CombellApi\Structure\LinuxHostings\Site;

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
        $this->setEndPoint('/v2/linuxhostings/'.$this->domainName);
    }

    public function processResponse(array $response)
    {
        $linuxHosting = $response['body'];

        $sites = [];
        foreach ($linuxHosting->sites as $site) {
            $hostHeaders = [];
            foreach ($site->host_headers as $hostHeader) {
                $hostHeaders[] = new HostHeader($hostHeader->name, $hostHeader->enabled);
            }
            $sites[] = new Site(
                $site->name,
                $site->path,
                $hostHeaders,
                $site->ssl_enabled,
                $site->https_redirect_enabled,
                $site->http2_enabled
            );
        }

        return new LinuxHosting(
            $linuxHosting->domain_name,
            $linuxHosting->servicepack_id,
            $linuxHosting->max_webspace_size,
            $linuxHosting->max_size,
            $linuxHosting->webspace_usage,
            $linuxHosting->actual_size,
            $linuxHosting->ip,
            $linuxHosting->ip_type,
            $linuxHosting->ftp_username,
            $linuxHosting->ssh_host,
            $linuxHosting->ssh_username,
            $linuxHosting->php_version,
            $sites,
            $linuxHosting->mysql_database_names
        );
    }
}

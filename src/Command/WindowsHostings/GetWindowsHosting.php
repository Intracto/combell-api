<?php

namespace TomCan\CombellApi\Command\WindowsHostings;

use TomCan\CombellApi\Command\AbstractCommand;
use TomCan\CombellApi\Structure\WindowsHostings\Site;
use TomCan\CombellApi\Structure\WindowsHostings\Binding;
use TomCan\CombellApi\Structure\WindowsHostings\WindowsHosting;

class GetWindowsHosting extends AbstractCommand
{
    private $domainName;

    public function __construct(string $domainName)
    {
        parent::__construct('get', '/v2/windowshostings');

        $this->domainName = $domainName;
    }

    public function prepare(): void
    {
        $this->setEndPoint('/v2/windowshostings/'.$this->domainName);
    }

    public function processResponse(array $response)
    {
        $windowsHosting = $response['body'];
        $sites = [];
        foreach ($windowsHosting->sites as $site) {
            $bindings = [];
            foreach ($site->bindings as $binding) {
                $bindings[] = new Binding($binding->host_name, $binding->protocol, $binding->ip_address, $binding->port, $binding->ssl_enabled, $binding->cert_thumbprint);
            }
            $sites[] = new Site(
                $site->name,
                $site->path,
                $bindings
            );
        }

        return new WindowsHosting(
            $windowsHosting->domain_name,
            $windowsHosting->servicepack_id,
            $windowsHosting->max_size,
            $windowsHosting->actual_size,
            $windowsHosting->ip,
            $windowsHosting->ip_type,
            $windowsHosting->ftp_username,
            $windowsHosting->application_pool->runtime . ' ' . $windowsHosting->application_pool->pipeline_mode,
            $sites,
            $windowsHosting->mssql_database_names
        );
    }
}

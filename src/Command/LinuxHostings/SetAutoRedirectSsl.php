<?php

namespace TomCan\CombellApi\Command\LinuxHostings;

use TomCan\CombellApi\Command\AbstractCommand;

class SetAutoRedirectSsl extends AbstractCommand
{
    private $domainName;
    private $hostname;
    private $enabled;

    public function __construct(string $domainName, string $hostname, bool $enabled)
    {
        parent::__construct('put', '/v2/linuxhostings/{domainName}/sslsettings/{hostname}/autoredirect');

        $this->domainName = $domainName;
        $this->hostname = $hostname;
        $this->enabled = $enabled;
    }

    public function prepare(): void
    {
        $this->setEndPoint('/v2/linuxhostings/' . $this->domainName . '/sslsettings/' . $this->hostname . '/autoredirect');

        $obj = new \stdClass();
        $obj->enabled = $this->enabled;

        $this->setBody((string) json_encode($obj));
    }

    public function processResponse(array $response)
    {
    }
}

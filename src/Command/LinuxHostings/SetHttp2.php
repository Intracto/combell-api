<?php

namespace TomCan\CombellApi\Command\LinuxHostings;

use TomCan\CombellApi\Command\AbstractCommand;

class SetHttp2 extends AbstractCommand
{
    private $domainName;
    private $siteName;
    private $enabled;

    public function __construct(string $domainName, string $siteName, bool $enabled)
    {
        parent::__construct('put', '/v2/linuxhostings/{domainName}/sites/{siteName}/http2/configuration');

        $this->domainName = $domainName;
        $this->siteName = $siteName;
        $this->enabled = $enabled;
    }

    public function prepare(): void
    {
        $this->setEndPoint('/v2/linuxhostings/' . $this->domainName . '/sites/' . $this->siteName . '/http2/configuration');

        $obj = new \stdClass();
        $obj->enabled = $this->enabled;

        $this->setBody((string) json_encode($obj));
    }

    public function processResponse(array $response)
    {
    }
}

<?php

namespace TomCan\CombellApi\Command\LinuxHostings;

use TomCan\CombellApi\Command\PageableAbstractCommand;
use TomCan\CombellApi\Structure\LinuxHostings\LinuxHosting;

class ListLinuxHostings extends PageableAbstractCommand
{
    public function __construct()
    {
        parent::__construct('get', '/v2/linuxhostings');
    }

    public function processResponse(array $response)
    {
        $hostings = [];
        foreach ($response['body'] as $hosting) {
            $hostings[] = new LinuxHosting($hosting->domain_name, $hosting->servicepack_id);
        }

        return $hostings;
    }
}

<?php

namespace TomCan\CombellApi\Command\LinuxHostings;

use TomCan\CombellApi\Command\AbstractCommand;
use TomCan\CombellApi\Structure\LinuxHostings\LinuxHosting;

class ListLinuxHostings extends AbstractCommand
{

    public function __construct()
    {
        parent::__construct("get", "/v2/linuxhostings");
    }

    public function processResponse($response)
    {

        $hostings = array();
        foreach ($response['body'] as $hosting) {
            $hostings[] = new LinuxHosting($hosting->domain_name, $hosting->servicepack_id);
        }
        $response['response'] = $hostings;

        return $response;
    }

}
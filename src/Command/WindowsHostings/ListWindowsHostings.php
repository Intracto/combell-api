<?php

namespace TomCan\CombellApi\Command\WindowsHostings;

use TomCan\CombellApi\Command\PageableAbstractCommand;
use TomCan\CombellApi\Structure\WindowsHostings\WindowsHostingSummary;

class ListWindowsHostings extends PageableAbstractCommand
{
    public function __construct()
    {
        parent::__construct('get', '/v2/windowshostings');
    }

    public function processResponse(array $response)
    {
        $hostings = [];
        foreach ($response['body'] as $hosting) {
            $hostings[] = new WindowsHostingSummary($hosting->domain_name, $hosting->servicepack_id);
        }

        return $hostings;
    }
}

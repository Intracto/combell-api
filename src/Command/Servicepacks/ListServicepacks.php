<?php

namespace TomCan\CombellApi\Command\Servicepacks;

use TomCan\CombellApi\Command\AbstractCommand;
use TomCan\CombellApi\Structure\Servicepacks\Servicepack;

class ListServicepacks extends AbstractCommand
{
    public function __construct()
    {
        parent::__construct('get', '/v2/servicepacks');
    }

    public function processResponse($response)
    {
        $servicepacks = [];
        foreach ($response['body'] as $sp) {
            $servicepacks[] = new Servicepack($sp->id, $sp->name);
        }

        $response['response'] = $servicepacks;

        return $response;
    }
}

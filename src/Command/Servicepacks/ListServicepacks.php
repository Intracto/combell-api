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

    public function prepare(): void
    {
    }

    public function processResponse(array $response)
    {
        $servicepacks = [];
        foreach ($response['body'] as $servicepack) {
            $servicepacks[] = new Servicepack($servicepack->id, $servicepack->name);
        }

        return $servicepacks;
    }
}

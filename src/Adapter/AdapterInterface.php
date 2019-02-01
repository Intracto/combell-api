<?php

namespace TomCan\CombellApi\Adapter;

interface AdapterInterface
{
    public function call(string $method, string $uri, array $headers, string $body): array;
}

<?php

namespace TomCan\CombellApi\Structure\WindowsHostings;

class Site
{
    private $name;
    private $path;
    private $bindings;

    public function __construct(
        string $name,
        string $path,
        array $bindings
    ) {
        $this->name = $name;
        $this->path = $path;
        $this->bindings = $bindings;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getPath(): string
    {
        return $this->path;
    }

    /**
     * @return Binding[]
     */
    public function getBindings(): array
    {
        return $this->bindings;
    }

}

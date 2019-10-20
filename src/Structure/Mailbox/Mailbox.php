<?php

namespace TomCan\CombellApi\Structure\Mailbox;

class Mailbox
{
    private $name;
    private $maxSize;
    private $actualSize;

    /**
     * @param string $name       email address
     * @param int    $maxSize    in megabyte
     * @param int    $actualSize in megabyte
     */
    public function __construct(string $name, int $maxSize, int $actualSize)
    {
        $this->name = $name;
        $this->maxSize = $maxSize;
        $this->actualSize = $actualSize;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getMaxSize(): int
    {
        return $this->maxSize;
    }

    public function getActualSize(): int
    {
        return $this->actualSize;
    }
}

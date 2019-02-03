<?php

namespace TomCan\CombellApi\Command;

abstract class PageableAbstractCommand extends AbstractCommand
{
    private $pagingSkipped = 0;
    private $pagingTake = 0;
    private $pagingTotalResults = 0;

    public function processHeaders(array $headers): void
    {
        $this->pagingSkipped = (int) current($headers['X-Paging-Skipped']);
        $this->pagingTake = (int) current($headers['X-Paging-Take']);
        $this->pagingTotalResults = (int) current($headers['X-Paging-TotalResults']);
    }

    public function getPagingSkipped(): int
    {
        return $this->pagingSkipped;
    }

    public function getPagingTake(): int
    {
        return $this->pagingTake;
    }

    public function getPagingTotalResults(): int
    {
        return $this->pagingTotalResults;
    }
}

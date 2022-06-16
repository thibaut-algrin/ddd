<?php

declare(strict_types=1);

namespace App\Infrastructure\Shared\ApiPlatform\State;

use ApiPlatform\State\Pagination\PaginatorInterface;

class Paginator implements PaginatorInterface, \IteratorAggregate
{
    private iterable $items;
    private float $currentPage;
    private float $itemsPerPage;
    private float $lastPage;
    private float $totalItems;

    public function __construct(
        iterable $items,
        float $currentPage,
        float $itemsPerPage,
        float $lastPage,
        float $totalItems
    ) {
        $this->items = $items;
        $this->currentPage = $currentPage;
        $this->itemsPerPage = $itemsPerPage;
        $this->lastPage = $lastPage;
        $this->totalItems = $totalItems;
    }


    public function getCurrentPage(): float
    {
        return $this->currentPage;
    }

    public function getItemsPerPage(): float
    {
        return $this->itemsPerPage;
    }

    public function getLastPage(): float
    {
        return $this->lastPage;
    }

    public function getTotalItems(): float
    {
        return $this->totalItems;
    }

    public function count(): int
    {
        return iterator_count($this->getIterator());
    }

    public function getIterator(): \Traversable
    {
        return new \ArrayIterator($this->items);
    }
}

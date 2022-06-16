<?php

declare(strict_types=1);

namespace App\Domain\Shared\Repository;

interface RepositoryInterface
{
    public function getIterator(): \Iterator;

    public function count(): int;

    public function paginator(): ?PaginatorInterface;

    public function withPagination(int $page, int $itemsPerPage): static;

    public function withoutPagination(): static;
}

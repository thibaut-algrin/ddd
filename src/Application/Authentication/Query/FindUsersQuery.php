<?php

declare(strict_types=1);

namespace App\Application\Authentication\Query;

use App\Application\Shared\Query\QueryInterface;

class FindUsersQuery implements QueryInterface
{
    public ?int $page = null;
    public ?int $itemsPerPage = null;

    public function __construct(?int $page, ?int $itemsPerPage)
    {
        $this->page = $page;
        $this->itemsPerPage = $itemsPerPage;
    }
}

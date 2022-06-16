<?php

declare(strict_types=1);

namespace App\Application\Authentication\Query;

use App\Application\Shared\Query\QueryInterface;
use Symfony\Component\Uid\Uuid;

class FindUserQuery implements QueryInterface
{
    public readonly Uuid $id;

    public function __construct(Uuid $id)
    {
        $this->id = $id;
    }
}

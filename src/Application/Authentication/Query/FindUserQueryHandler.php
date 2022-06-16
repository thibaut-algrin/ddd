<?php

declare(strict_types=1);

namespace App\Application\Authentication\Query;

use App\Application\Shared\Query\QueryHandlerInterface;
use App\Domain\Authentication\Model\User;
use App\Domain\Authentication\Repository\UserRepositoryInterface;

class FindUserQueryHandler implements QueryHandlerInterface
{
    private UserRepositoryInterface $repository;

    public function __construct(UserRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function __invoke(FindUserQuery $query): ?User
    {
        return $this->repository->ofId($query->id);
    }
}

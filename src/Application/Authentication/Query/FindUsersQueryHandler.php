<?php

declare(strict_types=1);

namespace App\Application\Authentication\Query;

use App\Application\Shared\Query\QueryHandlerInterface;
use App\Domain\Authentication\Repository\UserRepositoryInterface;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
class FindUsersQueryHandler implements QueryHandlerInterface
{
    private UserRepositoryInterface $userRepository;

    public function __construct(UserRepositoryInterface $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function __invoke(FindUsersQuery $query): UserRepositoryInterface
    {
        $bookRepository = $this->userRepository;

        if (null !== $query->page && null !== $query->itemsPerPage) {
            $bookRepository = $bookRepository->withPagination($query->page, $query->itemsPerPage);
        }

        return $bookRepository;
    }
}

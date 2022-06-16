<?php

declare(strict_types=1);

namespace App\Domain\Authentication\Repository;

use App\Domain\Authentication\Model\User;
use App\Domain\Shared\Repository\RepositoryInterface;
use Symfony\Component\Uid\Uuid;

interface UserRepositoryInterface extends RepositoryInterface
{
    public function add(User $user): void;

    public function remove(User $user): void;

    public function ofId(Uuid $id): ?User;
}

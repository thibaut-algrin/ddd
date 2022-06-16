<?php

declare(strict_types=1);

namespace App\Infrastructure\Authentication\Doctrine\Repository;

use App\Domain\Authentication\Model\User;
use App\Domain\Authentication\Repository\UserRepositoryInterface;
use App\Infrastructure\Shared\Doctrine\DoctrineRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Uid\Uuid;

class UserRepository extends DoctrineRepository implements UserRepositoryInterface
{
    private const ENTITY_CLASS = User::class;
    private const ALIAS = 'user';

    public function __construct(EntityManagerInterface $em)
    {
        parent::__construct($em, self::ENTITY_CLASS, self::ALIAS);
    }

    public function add(User $user): void
    {
        $this->em->persist($user);
        $this->em->flush();
    }

    public function remove(User $user): void
    {
        $this->em->remove($user);
        $this->em->flush();
    }

    public function ofId(Uuid $id): ?User
    {
        return $this->em->find(self::ENTITY_CLASS, $id);
    }
}

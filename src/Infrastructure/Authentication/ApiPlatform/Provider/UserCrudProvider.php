<?php

declare(strict_types=1);

namespace App\Infrastructure\Authentication\ApiPlatform\Provider;

use ApiPlatform\Metadata\CollectionOperationInterface;
use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\Pagination\Pagination;
use ApiPlatform\State\ProviderInterface;
use App\Application\Authentication\Query\FindUserQuery;
use App\Application\Authentication\Query\FindUsersQuery;
use App\Application\Shared\Query\QueryBusInterface;
use App\Domain\Authentication\Model\User;
use App\Domain\Authentication\Repository\UserRepositoryInterface;
use App\Infrastructure\Authentication\ApiPlatform\Resource\UserResource;
use App\Infrastructure\Shared\ApiPlatform\State\Paginator;

class UserCrudProvider implements ProviderInterface
{
    private QueryBusInterface $queryBus;
    private Pagination $pagination;

    public function __construct(QueryBusInterface $queryBus, Pagination $pagination)
    {
        $this->queryBus = $queryBus;
        $this->pagination = $pagination;
    }

    public function provide(Operation $operation, array $uriVariables = [], array $context = []): object|array|null
    {
        if (!$operation instanceof CollectionOperationInterface) {
            /** @var User|null $model */
            $model = $this->queryBus->ask(new FindUserQuery($uriVariables['id']));

            return null !== $model ? UserResource::fromModel($model) : null;
        }

        $offset = $limit = null;

        if ($this->pagination->isEnabled($operation->getClass(), $operation->getName(), $context)) {
            $offset = $this->pagination->getPage($context);
            $limit = $this->pagination->getLimit($operation->getClass(), $operation->getName(), $context);
        }

        /** @var UserRepositoryInterface $models */
        $models = $this->queryBus->ask(new FindUsersQuery($offset, $limit));

        $resources = [];
        foreach ($models as $model) {
            $resources[] = UserResource::fromModel($model);
        }

        if (null !== $paginator = $models->paginator()) {
            $resources = new Paginator(
                $resources,
                (float) $paginator->getCurrentPage(),
                (float) $paginator->getItemsPerPage(),
                (float) $paginator->getLastPage(),
                (float) $paginator->getTotalItems(),
            );
        }

        return $resources;
    }
}

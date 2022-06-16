<?php

declare(strict_types=1);

namespace App\Infrastructure\Authentication\ApiPlatform\Processor;

use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProcessorInterface;

class UserCrudProcessor implements ProcessorInterface
{
    public function process($data, Operation $operation, array $uriVariables = [], array $context = [])
    {
        // TODO: Implement process() method.
    }
}

<?php

declare(strict_types=1);

namespace App\Component\User;

use ApiPlatform\State\ProviderInterface;
use Symfony\Bundle\SecurityBundle\Security;
use ApiPlatform\Metadata\Operation;

readonly class CurrentUserProvider implements ProviderInterface
{
    public function __construct(
        private Security $security
    )
    {}
    public function provide(
        Operation $operation,
        array $uriVariables = [],
        array $context =[]
    ): object|array|null
    {
        return $this->security->getUser();
    }
}

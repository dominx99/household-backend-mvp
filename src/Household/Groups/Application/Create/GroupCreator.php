<?php

declare(strict_types=1);

namespace App\Household\Groups\Application\Create;

use App\Household\Groups\Domain\Group;
use App\Household\Groups\Infrastructure\Persistence\GroupRepository;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

final class GroupCreator
{
    public function __construct(private GroupRepository $repository, private TokenStorageInterface $tokenStorage)
    {
    }

    public function __invoke(Group $group): void
    {
        $user = $this->tokenStorage->getToken()->getUser();

        $group->__construct();
        $group->addUser($user);

        $this->repository->save($group);
    }
}

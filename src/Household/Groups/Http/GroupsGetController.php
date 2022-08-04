<?php

declare(strict_types=1);

namespace App\Household\Groups\Http;

use App\Household\Groups\Infrastructure\Persistence\GroupRepository;
use App\Shared\Http\Symfony\ApiController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

final class GroupsGetController extends ApiController
{
    public function __construct(private GroupRepository $repository, private TokenStorageInterface $tokenStorage)
    {
    }

    #[Route('api/v1/groups', methods: ['GET'])]
    public function __invoke(): Response
    {
        /** @var \App\Auth\Domain\User $user */
        $user = $this->tokenStorage->getToken()->getUser();

        return $this->respond($user->getUserGroups());
    }
}

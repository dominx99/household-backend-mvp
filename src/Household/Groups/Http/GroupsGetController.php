<?php

declare(strict_types=1);

namespace App\Household\Groups\Http;

use App\Household\Groups\Infrastructure\Persistence\GroupRepository;
use App\Shared\Http\Symfony\ApiController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

final class GroupsGetController extends ApiController
{
    public function __construct(private GroupRepository $repository)
    {
    }

    #[Route('api/v1/groups', methods: ['GET'])]
    public function __invoke(): Response
    {
        return $this->respond(
            $this->repository->findAll(),
        );
    }
}

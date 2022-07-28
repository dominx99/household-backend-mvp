<?php

declare(strict_types=1);

namespace App\Household\Groups\Http;

use App\Household\Groups\Infrastructure\Persistence\GroupRepository;
use App\Shared\Domain\Enum\RegexConstants;
use Symfony\Component\HttpFoundation\Response;
use App\Shared\Http\Symfony\ApiController;
use Symfony\Component\Routing\Annotation\Route;

final class GroupGetController extends ApiController
{
    public function __construct(private GroupRepository $repository)
    {
    }

    #[Route('api/v1/groups/{groupId}', methods: ['GET'], requirements: [
        'groupId' => RegexConstants::UUID,
    ])]
    public function __invoke(
        string $groupId,
    ): Response {
        return ($group = $this->repository->find($groupId))
            ? $this->respond($group)
            : $this->throwNotFound(sprintf('Group %s not found'));
    }
}

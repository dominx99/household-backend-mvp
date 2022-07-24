<?php

declare(strict_types=1);

namespace App\Household\Groups\Http;

use App\Household\Groups\Application\Create\GroupCreator;
use App\Household\Groups\Domain\Group;
use App\Shared\Http\Symfony\ApiController;
use App\Shared\Http\Symfony\SuccessResponse;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\ConstraintViolationListInterface;
use function Lambdish\Phunctional\apply;

final class GroupsPostController extends ApiController
{
    public function __construct(private GroupCreator $creator)
    {
    }

    #[Route('api/v1/groups', methods: ['POST'])]
    #[ParamConverter('group', converter: 'fos_rest.request_body')]
    public function __invoke(
        Group $group,
        ConstraintViolationListInterface $violations
    ): Response {
        $violations->count() > 0
            ? $this->throwValidationFailedError($violations)
            : $this->createGroup($group);

        return new SuccessResponse();
    }

    private function createGroup(Group $group): void
    {
        apply($this->creator, [$group]);
    }
}

<?php

declare(strict_types=1);

namespace App\Household\ShoppingLists\Http;

use App\Household\ShoppingLists\Application\Create\ShoppingListCreator;
use App\Household\ShoppingLists\Domain\ShoppingList;
use App\Shared\Domain\Utils;
use App\Shared\Domain\ValidationFailedError;
use App\Shared\Http\Symfony\SuccessResponse;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\ConstraintViolationListInterface;

use function Lambdish\Phunctional\apply;

final class ShoppingListsPostController
{
    public function __construct(
        private ShoppingListCreator $creator,
    ) {
    }

    #[Route('api/v1/groups/{groupId}/shopping-lists', methods: ['POST'])]
    #[ParamConverter('shoppingList', converter: 'fos_rest.request_body', options: [
        'validator' => [
            'groups' => ['POST'],
        ],
    ])]
    public function __invoke(
        ConstraintViolationListInterface $violations,
        ShoppingList $shoppingList,
        string $groupId,
    ): JsonResponse {
        $violations->count() > 0
            ? $this->validate($violations)
            : $this->createShoppingList($shoppingList, $groupId);

        return new SuccessResponse(SuccessResponse::HTTP_CREATED);
    }

    private function createShoppingList(ShoppingList $shoppingList, string $groupId): void
    {
        apply($this->creator, [$shoppingList, $groupId]);
    }

    private function validate(ConstraintViolationListInterface $violations): void
    {
        throw new ValidationFailedError(Utils::formatViolations($violations));
    }
}

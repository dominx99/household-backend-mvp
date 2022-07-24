<?php

declare(strict_types=1);

namespace App\ShoppingLists\Http;

use App\Shared\Domain\Utils;
use App\Shared\Domain\ValidationFailedError;
use App\ShoppingLists\Domain\ShoppingList;
use App\ShoppingLists\Infrastructure\Persistence\ShoppingListRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\ConstraintViolationListInterface;

final class ShoppingListsPostController
{
    public function __construct(
        private ShoppingListRepository $repository,
    ) {
    }

    #[Route('api/v1/shopping-lists', methods: ['POST'])]
    #[ParamConverter('shoppingList', converter: 'fos_rest.request_body')]
    public function __invoke(
        ShoppingList $shoppingList,
        ConstraintViolationListInterface $violations,
    ): JsonResponse {
        $violations->count() > 0
            ? $this->validate($violations)
            : $this->createShoppingList($shoppingList);

        return new JsonResponse(['status' => 'OK']);
    }

    private function createShoppingList(ShoppingList $shoppingList): void
    {
        $this->repository->save($shoppingList);
    }

    private function validate(ConstraintViolationListInterface $violations): void
    {
        throw new ValidationFailedError(Utils::formatViolations($violations));
    }
}

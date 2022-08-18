<?php

declare(strict_types=1);

namespace App\Household\ShoppingLists\Http;

use App\Household\ShoppingLists\Infrastructure\Persistence\ShoppingListRepository;
use App\Shared\Http\Symfony\ApiController;
use App\Shared\Http\Symfony\SuccessResponse;
use Symfony\Component\Routing\Annotation\Route;

final class ShoppingListDeleteController extends ApiController
{
    public function __construct(private ShoppingListRepository $repository)
    {
    }

    #[Route('api/v1/shopping-lists/{shoppingListId}', methods: ['DELETE'])]
    public function __invoke(string $shoppingListId): SuccessResponse
    {
        if (!$shoppingList = $this->repository->find($shoppingListId)) {
            $this->throwNotFound(sprintf('Shopping list %s not found', $shoppingListId));
        }

        $this->repository->remove($shoppingList);

        return new SuccessResponse(SuccessResponse::HTTP_NO_CONTENT);
    }
}

<?php

declare(strict_types=1);

namespace App\Household\ShoppingListItems\Http;

use App\Household\ShoppingListItems\Infrastructure\Persistence\ShoppingListItemRepository;
use App\Shared\Http\Symfony\ApiController;
use App\Shared\Http\Symfony\SuccessResponse;
use Symfony\Component\Routing\Annotation\Route;

final class ShoppingListItemDeleteController extends ApiController
{
    public function __construct(private ShoppingListItemRepository $repository)
    {
    }

    #[Route('api/v1/shopping-list-items/{shoppingListItemId}', methods: ['DELETE'])]
    public function __invoke(string $shoppingListItemId): SuccessResponse
    {
        if (!$shoppingListItem = $this->repository->find($shoppingListItemId)) {
            $this->throwNotFound(sprintf('Shopping list item %s not found'));
        }

        $this->repository->remove($shoppingListItem);

        return new SuccessResponse(SuccessResponse::HTTP_NO_CONTENT);
    }
}

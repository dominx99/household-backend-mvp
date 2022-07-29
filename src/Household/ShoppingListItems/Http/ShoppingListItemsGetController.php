<?php

declare(strict_types=1);

namespace App\Household\ShoppingListItems\Http;

use App\Household\ShoppingListItems\Infrastructure\Persistence\ShoppingListItemRepository;
use App\Shared\Http\Symfony\ApiController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

final class ShoppingListItemsGetController extends ApiController
{
    public function __construct(private ShoppingListItemRepository $repository)
    {
    }

    #[Route('api/v1/shopping-lists/{shoppingListId}/items', methods: ['GET'])]
    public function __invoke(string $shoppingListId): Response
    {
        return $this->respond(
            $this->repository->findBy(['shoppingList' => $shoppingListId])
        );
    }
}

<?php

declare(strict_types=1);

namespace App\Household\ShoppingLists\Http;

use App\Household\ShoppingLists\Infrastructure\Persistence\ShoppingListRepository;
use App\Shared\Http\Symfony\ApiController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

final class ShoppingListsGetController extends ApiController
{
    #[Route('api/v1/groups/{groupId}/shopping-lists')]
    public function __invoke(ShoppingListRepository $repository, string $groupId): Response
    {
        return $this->respond(
            $repository->findBy(['shoppingListGroup' => $groupId])
        );
    }
}

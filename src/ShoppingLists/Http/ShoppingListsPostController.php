<?php

declare(strict_types=1);

namespace App\ShoppingLists\Http;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

final class ShoppingListsPostController
{
    #[Route('api/v1/shopping-lists')]
    public function __invoke(): JsonResponse
    {
        return new JsonResponse(['status' => 'OK']);
    }
}

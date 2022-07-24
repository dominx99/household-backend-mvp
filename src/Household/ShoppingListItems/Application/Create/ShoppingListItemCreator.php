<?php

declare(strict_types=1);

namespace App\Household\ShoppingListItems\Application\Create;

use App\Household\ShoppingListItems\Domain\ShoppingListItem;
use App\Household\ShoppingListItems\Infrastructure\Persistence\ShoppingListItemRepository;
use App\Household\ShoppingLists\Infrastructure\Persistence\ShoppingListRepository;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

final class ShoppingListItemCreator
{
    public function __construct(
        private ShoppingListRepository $shoppingListRepository,
        private ShoppingListItemRepository $shoppingListItemRepository,
    ) {
    }

    public function __invoke(ShoppingListItem $item, string $shoppingListId): void
    {
        if (!$shoppingList = $this->shoppingListRepository->find($shoppingListId)) {
            throw new NotFoundHttpException('Shopping list not found');
        }

        $item->setShoppingList($shoppingList);
        $this->shoppingListItemRepository->save($item);
    }
}

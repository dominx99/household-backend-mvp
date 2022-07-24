<?php

declare(strict_types=1);

namespace App\Household\ShoppingLists\Application\Create;

use App\Household\Groups\Infrastructure\Persistence\GroupRepository;
use App\Household\ShoppingLists\Domain\ShoppingList;
use App\Household\ShoppingLists\Infrastructure\Persistence\ShoppingListRepository;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

final class ShoppingListCreator
{
    public function __construct(
        private ShoppingListRepository $shoppingListRepository,
        private GroupRepository $groupRepository,
    ) {
    }

    public function __invoke(ShoppingList $shoppingList, string $groupId): void
    {
        if (!$group = $this->groupRepository->find($groupId)) {
            throw new NotFoundHttpException('Group not found.');
        }

        $shoppingList->setShoppingListGroup($group);

        $this->shoppingListRepository->save($shoppingList);
    }
}

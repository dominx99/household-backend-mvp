<?php

namespace App\Factory;

use App\Household\ShoppingLists\Domain\ShoppingList;
use App\Household\ShoppingLists\Infrastructure\Persistence\ShoppingListRepository;
use Zenstruck\Foundry\RepositoryProxy;
use Zenstruck\Foundry\ModelFactory;
use Zenstruck\Foundry\Proxy;

/**
 * @extends ModelFactory<ShoppingList>
 *
 * @method static             ShoppingList|Proxy createOne(array $attributes = [])
 * @method static             ShoppingList[]|Proxy[] createMany(int $number, array|callable $attributes = [])
 * @method static             ShoppingList|Proxy find(object|array|mixed $criteria)
 * @method static             ShoppingList|Proxy findOrCreate(array $attributes)
 * @method static             ShoppingList|Proxy first(string $sortedField = 'id')
 * @method static             ShoppingList|Proxy last(string $sortedField = 'id')
 * @method static             ShoppingList|Proxy random(array $attributes = [])
 * @method static             ShoppingList|Proxy randomOrCreate(array $attributes = [])
 * @method static             ShoppingList[]|Proxy[] all()
 * @method static             ShoppingList[]|Proxy[] findBy(array $attributes)
 * @method static             ShoppingList[]|Proxy[] randomSet(int $number, array $attributes = [])
 * @method static             ShoppingList[]|Proxy[] randomRange(int $min, int $max, array $attributes = [])
 * @method static             ShoppingListRepository|RepositoryProxy repository()
 * @method ShoppingList|Proxy create(array|callable $attributes = [])
 */
final class ShoppingListFactory extends ModelFactory
{
    protected function getDefaults(): array
    {
        return [
            'name' => self::faker()->words(rand(1, 3), true),
            'shoppingListGroup' => GroupFactory::random(),
        ];
    }

    protected static function getClass(): string
    {
        return ShoppingList::class;
    }
}

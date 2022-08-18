<?php

namespace App\Factory;

use App\Household\ShoppingListItems\Domain\ShoppingListItem;
use App\Household\ShoppingListItems\Infrastructure\Persistence\ShoppingListItemRepository;
use Zenstruck\Foundry\RepositoryProxy;
use Zenstruck\Foundry\ModelFactory;
use Zenstruck\Foundry\Proxy;

/**
 * @extends ModelFactory<ShoppingListItem>
 *
 * @method static                 ShoppingListItem|Proxy createOne(array $attributes = [])
 * @method static                 ShoppingListItem[]|Proxy[] createMany(int $number, array|callable $attributes = [])
 * @method static                 ShoppingListItem|Proxy find(object|array|mixed $criteria)
 * @method static                 ShoppingListItem|Proxy findOrCreate(array $attributes)
 * @method static                 ShoppingListItem|Proxy first(string $sortedField = 'id')
 * @method static                 ShoppingListItem|Proxy last(string $sortedField = 'id')
 * @method static                 ShoppingListItem|Proxy random(array $attributes = [])
 * @method static                 ShoppingListItem|Proxy randomOrCreate(array $attributes = [])
 * @method static                 ShoppingListItem[]|Proxy[] all()
 * @method static                 ShoppingListItem[]|Proxy[] findBy(array $attributes)
 * @method static                 ShoppingListItem[]|Proxy[] randomSet(int $number, array $attributes = [])
 * @method static                 ShoppingListItem[]|Proxy[] randomRange(int $min, int $max, array $attributes = [])
 * @method static                 ShoppingListItemRepository|RepositoryProxy repository()
 * @method ShoppingListItem|Proxy create(array|callable $attributes = [])
 */
final class ShoppingListItemFactory extends ModelFactory
{
    protected function getDefaults(): array
    {
        return [
            'id' => self::faker()->uuid(),
            'name' => self::faker()->words(rand(1, 2), true),
            'shoppingList' => ShoppingListFactory::random(),
        ];
    }

    protected static function getClass(): string
    {
        return ShoppingListItem::class;
    }
}

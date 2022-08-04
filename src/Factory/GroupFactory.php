<?php

namespace App\Factory;

use App\Household\Groups\Domain\Group;
use App\Household\Groups\Infrastructure\Persistence\GroupRepository;
use Zenstruck\Foundry\RepositoryProxy;
use Zenstruck\Foundry\ModelFactory;
use Zenstruck\Foundry\Proxy;

/**
 * @extends ModelFactory<Group>
 *
 * @method static      Group|Proxy createOne(array $attributes = [])
 * @method static      Group[]|Proxy[] createMany(int $number, array|callable $attributes = [])
 * @method static      Group|Proxy find(object|array|mixed $criteria)
 * @method static      Group|Proxy findOrCreate(array $attributes)
 * @method static      Group|Proxy first(string $sortedField = 'id')
 * @method static      Group|Proxy last(string $sortedField = 'id')
 * @method static      Group|Proxy random(array $attributes = [])
 * @method static      Group|Proxy randomOrCreate(array $attributes = [])
 * @method static      Group[]|Proxy[] all()
 * @method static      Group[]|Proxy[] findBy(array $attributes)
 * @method static      Group[]|Proxy[] randomSet(int $number, array $attributes = [])
 * @method static      Group[]|Proxy[] randomRange(int $min, int $max, array $attributes = [])
 * @method static      GroupRepository|RepositoryProxy repository()
 * @method Group|Proxy create(array|callable $attributes = [])
 */
final class GroupFactory extends ModelFactory
{
    protected function getDefaults(): array
    {
        return [
            'name' => self::faker()->company(),
        ];
    }

    protected static function getClass(): string
    {
        return Group::class;
    }
}

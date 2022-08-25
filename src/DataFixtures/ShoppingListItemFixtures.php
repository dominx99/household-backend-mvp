<?php

declare(strict_types=1);

namespace App\DataFixtures;

use App\Factory\ShoppingListItemFactory;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

final class ShoppingListItemFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        ShoppingListItemFactory::createMany(500);
    }

    public function getDependencies(): array
    {
        return [
            ShoppingListFixtures::class,
        ];
    }
}

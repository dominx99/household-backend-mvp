<?php

declare(strict_types=1);

namespace App\DataFixtures;

use App\Factory\ShoppingListFactory;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

final class ShoppingListFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        ShoppingListFactory::createMany(100);
    }

    public function getDependencies(): array
    {
        return [
            GroupFixtures::class,
        ];
    }
}

<?php

declare(strict_types=1);

namespace App\DataFixtures;

use App\Factory\UserFactory;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

final class UserFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        UserFactory::createOne([
            'email' => 'admin@chylo.pl',
            'password' => 'admin123',
            'roles' => ['ROLE_USER', 'ROLE_ADMIN'],
        ]);

        UserFactory::createOne([
            'email' => 'user@chylo.pl',
            'password' => 'user123',
            'roles' => ['ROLE_USER'],
        ]);
    }

    public function getDependencies(): array
    {
        return [GroupFixtures::class];
    }
}

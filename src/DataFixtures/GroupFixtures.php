<?php

namespace App\DataFixtures;

use App\Factory\GroupFactory;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;

class GroupFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        GroupFactory::new()->createMany(4);
    }
}

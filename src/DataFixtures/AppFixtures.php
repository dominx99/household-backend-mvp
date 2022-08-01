<?php

namespace App\DataFixtures;

use App\Auth\Domain\User;
use App\Household\Groups\Domain\Group;
use App\Household\ShoppingListItems\Domain\ShoppingListItem;
use App\Household\ShoppingLists\Domain\ShoppingList;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory as FakerFactory;
use Faker\Generator as Faker;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AppFixtures extends Fixture
{
    private Faker $faker;

    public function __construct(private UserPasswordHasherInterface $passwordHasher)
    {
    }

    public function load(ObjectManager $manager): void
    {
        $this->initializeFaker();

        ($user = (new User()))
            ->setEmail('admin@chylo.pl')
            ->setPassword($this->passwordHasher->hashPassword($user, 'admin123'))
        ;

        $group = (new Group())
            ->setName($this->faker->company)
        ;

        $shoppingList = (new ShoppingList())
            ->setName($this->faker->title)
            ->setShoppingListGroup($group)
        ;

        $shoppingListItem = (new ShoppingListItem())
            ->setName($this->faker->title)
            ->setShoppingList($shoppingList)
        ;

        $manager->persist($user);
        $manager->persist($group);
        $manager->persist($shoppingList);
        $manager->persist($shoppingListItem);

        $manager->flush();
    }

    public function initializeFaker(): void
    {
        if (!isset($this->faker)) {
            $this->faker = FakerFactory::create();
        }
    }
}

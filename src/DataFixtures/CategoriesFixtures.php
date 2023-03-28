<?php

namespace App\DataFixtures;

use App\Entity\Categories;
use App\Entity\Users;
use App\Repository\UsersRepository;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class CategoriesFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create('fr_FR');
        $users = $manager->getRepository(Users::class)->findByRole('CLIENT');
        // pwd = test
        for ($i=0; $i < 100; $i++) {
            $object = (new Categories())
                ->setLabel($faker->word)
            ;
            $users = $faker->randomElements($users, $faker->numberBetween(1, count($users)));
            foreach ($users as $user) {
                $object->addUser($user);
            }
            $manager->persist($object);
        }

        $manager->flush();
    }

    public function getDependencies(): array
    {
        return [
            UsersFixtures::class,
        ];
    }
}

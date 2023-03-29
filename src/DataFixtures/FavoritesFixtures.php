<?php

namespace App\DataFixtures;

use App\Entity\Categories;
use App\Entity\Contents;
use App\Entity\Favorites;
use App\Entity\Offers;
use App\Entity\Users;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class FavoritesFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create('fr_FR');
        $users = $manager->getRepository(Users::class)->findByRole('CLIENT');
        $contents = $manager->getRepository(Contents::class)->findAll();

        for ($i=0; $i < 100; $i++) {
            $object = new Categories();
            $contents = $faker->randomElements($contents, $faker->numberBetween(1, count($contents)));
            foreach ($contents as $content) {
                $object->addContent($content);
            }
            $users = $faker->randomElements($users, $faker->numberBetween(1, count($users)));
            foreach ($users as $user) {
                $object->addUser($user);
            }
            $manager->persist($object);
        }


        $manager->flush();
    }
}

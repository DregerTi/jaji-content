<?php

namespace App\DataFixtures;

use App\Entity\Categories;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class CategoriesFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create('fr_FR');
        // pwd = test
        for ($i=0; $i < 100; $i++) {
            $object = (new Categories())
                ->setLabel($faker->word)
            ;
            $manager->persist($object);
        }

        $manager->flush();
    }
}

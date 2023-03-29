<?php

namespace App\DataFixtures;

use App\Entity\Offers;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class OffersFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create('fr_FR');

        $object = (new Offers())
            ->setTitle('dentaire')
            ->setLink($faker->words($faker->numberBetween(1, 5), true))
        ;

        $manager->persist($object);

        $object = (new Offers())
            ->setTitle('optique')
            ->setLink($faker->words($faker->numberBetween(1, 5), true))
        ;

        $manager->persist($object);

        $object = (new Offers())
            ->setTitle('général')
            ->setLink($faker->words($faker->numberBetween(1, 5), true))
        ;

        $manager->persist($object);


        $manager->flush();
    }
}

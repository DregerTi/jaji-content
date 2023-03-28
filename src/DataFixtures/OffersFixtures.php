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
            ->setTitle('Dentaire')
            ->setLink($faker->words($faker->numberBetween(1, 5), true))
            ->setCreatedAt($faker->dateTimeBetween('-1 years', 'now'))
        ;

        $manager->persist($object);

        $object = (new Offers())
            ->setTitle('Optique')
            ->setLink($faker->words($faker->numberBetween(1, 5), true))
            ->setCreatedAt($faker->dateTimeBetween('-1 years', 'now'))
        ;

        $manager->persist($object);

        $object = (new Offers())
            ->setTitle('Général')
            ->setLink($faker->words($faker->numberBetween(1, 5), true))
            ->setCreatedAt($faker->dateTimeBetween('-1 years','now'))
        ;

        $manager->persist($object);


        $manager->flush();
    }
}

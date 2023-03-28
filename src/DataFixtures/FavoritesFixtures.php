<?php

namespace App\DataFixtures;

use App\Entity\Contents;
use App\Entity\Favorites;
use App\Entity\Offers;
use App\Entity\Users;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class FavoritesFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create('fr_FR');
        $clients = $manager->getRepository(Users::class)->findByRole('CLIENT');
        $contents = $manager->getRepository(Contents::class)->findAll();

        for ($i=0; $i<1000; $i++) {
            $object = (new Favorites())
            ->setLiker($faker->randomElement($clients))
                ->setContent($faker->randomElement($contents))
            ;

            $manager->persist($object);
        }


        $manager->flush();
    }

    public function getDependencies(): array
    {
        return [
            ContentsFixtures::class,
        ];
    }
}

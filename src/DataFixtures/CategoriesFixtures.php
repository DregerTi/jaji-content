<?php

namespace App\DataFixtures;

use App\Entity\Categories;
use App\Entity\Users;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class CategoriesFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create('fr_FR');
        $users = $manager->getRepository(Users::class)->findByRole('CLIENT');
        $featherIconsList = ['activity', 'clipboard', 'droplet', 'eye', 'map', 'phone-call', 'thermometer'];

        $usedWords = [];
        for ($i=0; $i < 100; $i++) {
            do {
                $word = $faker->word;
            }
            while (in_array($word, $usedWords, true)) ;
            $object = (new Categories())
                ->setLabel($word)
            ;
            $usedWords[] = $word;
            $object->setIconReference($faker->randomElement($featherIconsList));
            $manager->persist($object);
        }

        $manager->flush();
    }

}

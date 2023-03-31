<?php

namespace App\DataFixtures;

use App\Entity\Categories;
use App\Entity\Users;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class UsersFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        // pwd = test
        $pwd = '$2y$13$r/sNDkWI9w4h0XHSIYqYJusHu3JYZTFwEOxTCkXG31rL9Dy1Tncba';
        $faker = Factory::create('fr_FR');
        $categories = $manager->getRepository(Categories::class)->findAll();

        $object = (new Users())
            ->setEmail('admin@admin.fr')
            ->setFirstname('admin')
            ->setLastname('admin')
            ->setRoles(["ROLE_ADMIN"])
            ->setPassword($pwd)
        ;
        $manager->persist($object);

        $object = (new Users())
            ->setEmail('editeur@editeur.fr')
            ->setFirstname('editeur')
            ->setLastname('editeur')
            ->setRoles(["ROLE_EDITEUR"])
            ->setPassword($pwd)
        ;
        $manager->persist($object);

        $object = (new Users())
            ->setEmail('client@user.fr')
            ->setFirstname('client')
            ->setLastname('client')
            ->setRoles(["ROLE_CLIENT"])
            ->setPassword($pwd)
        ;
        $manager->persist($object);

        for ($i=0; $i < 100; $i++) {
            $object = (new Users())
                ->setEmail($faker->email)
                ->setFirstname($faker->firstName)
                ->setLastname($faker->lastName)
                ->setRoles(["ROLE_CLIENT"])
                ->setPassword($pwd);

            $userCategories = $faker->randomElements($categories, $faker->numberBetween(1, 15));
            foreach ($userCategories as $userCategory) {
                $object->addCategory($userCategory);
            }

            $manager->persist($object);
        }


        $manager->flush();
    }

    public function getDependencies(): array
    {
        return [
            CategoriesFixtures::class,
        ];
    }
}

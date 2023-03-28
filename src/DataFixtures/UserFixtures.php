<?php

namespace App\DataFixtures;

use App\Entity\Users;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class UserFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        // pwd = test
        $pwd = '$2y$13$r/sNDkWI9w4h0XHSIYqYJusHu3JYZTFwEOxTCkXG31rL9Dy1Tncba';

        $object = (new Users())
            ->setEmail('admin@admin.fr')
            ->setFirstname('admin')
            ->setLastname('admin')
            ->setRoles(["ADMIN"])
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

        $object = (new Users())
            ->setEmail('admin@user.fr')
            ->setRoles(['ROLE_ADMIN'])
            ->setPassword($pwd)
        ;
        $manager->persist($object);

        $manager->flush();
    }
}

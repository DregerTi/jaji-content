<?php

namespace App\DataFixtures;

use App\Entity\Categories;
use App\Entity\Contents;
use App\Entity\Users;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class ContentsFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        $types = ['Youtube', 'Spotify', 'Article'];
        $faker = Factory::create('fr_FR');
        $users = array_merge($manager->getRepository(Users::class)->findByRole('EDITEUR'), $manager->getRepository(Users::class)->findByRole('ADMIN'));
        $categories = $manager->getRepository(Categories::class)->findAll();

        for ($i=0; $i < 100; $i++) {
            $object = (new Contents())
                ->setType($faker->randomElements($types, $faker->numberBetween(1, 1))[0])
                ->setTitle($faker->words($faker->numberBetween(1, 5), true))
                ->setDescription($faker->text(100))
            ;

            switch ($object->getType()) {
                case 'Youtube':
                    $object->setSrc('<iframe width="560" height="315" src="https://www.youtube.com/embed/n4DB-oay4XQ" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" allowfullscreen></iframe>')
                        ->setContent($faker->text(100));
                    break;
                case 'Spotify':
                    $object->setSrc('<iframe style="border-radius:12px" src="https://open.spotify.com/embed/track/3LbYXe4nxvgTYofXbceuXs?utm_source=generator" width="100%" height="352" frameBorder="0" allowfullscreen="" allow="autoplay; clipboard-write; encrypted-media; fullscreen; picture-in-picture" loading="lazy"></iframe>')
                        ->setContent($faker->text(100));
                    break;
                case 'Article':
                    $object->setContent($faker->text(1000));
                    $object->setPrewiewImg($faker->imageUrl(640, 480, 'cats', true, 'Faker', true));
                    break;
                    default:
                    break;
            }

            $objectCategory = $faker->randomElements($categories, $faker->numberBetween(1, 10));
            foreach ($objectCategory as $category) {
                $object->addCategory($category);
            }

            $object->setCreatedAt($faker->dateTimeBetween('-1 years', 'now'));
            $object->setCreatedBy($faker->randomElement($users));
            if (random_int(0, 1) === 1) {
                $object->setUpdatedAt($faker->dateTimeBetween($object->getCreatedAt()?->format('Y-m-d H:i:s'), 'now'));
                $object->setUpdatedBy($faker->randomElement($users));
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

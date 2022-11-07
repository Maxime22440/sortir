<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Faker;

class Lieu extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {

        $faker = Faker\Factory::create('fr_FR');
        // $product = new Product();
        // $manager->persist($product);
        $mairie= new \App\Entity\Lieu;

        $mairie->setNom("Mairie de Rennes");
        $mairie->setRue("Pl. de la Mairie");
        $mairie->setLatitude(48.117266);
        $mairie->setLongitude(-1.6777926);
        $mairie->setVille($this->getReference('Rennes'));
        $manager->persist($mairie);
        $this->addReference('Mairie de Rennes', $mairie);





        for($i=0;$i<30;$i++) {
            $lieu = new \App\Entity\Lieu;

            $lieu->setNom($faker->name);
            $lieu->setRue($faker->address);
            $lieu->setLatitude($faker->randomFloat());
            $lieu->setLongitude($faker->randomFloat());
            $lieu->setVille($this->getReference('Rennes'));
            $manager->persist($lieu);


        }




        $manager->flush();


    }

    public function getDependencies()
    {
        return[
            Ville::class,
        ];
    }
}

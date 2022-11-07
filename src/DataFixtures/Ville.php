<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker;

class Ville extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $faker = Faker\Factory::create('fr_FR');

        // $product = new Product();
        // $manager->persist($product);

        $rennes = new \App\Entity\Ville();
        $rennes->setNom("Rennes");
        $rennes->setCodePostal("35000");
        $manager->persist($rennes);
        $this->addReference('Rennes', $rennes);


        for($i=0;$i<30;$i++) {

            $city[$i] = new \App\Entity\Ville();
            $city[$i]->setNom($faker->city);
            $city[$i]->setCodePostal('35000');
            $manager->persist($city[$i]);

        }



        $manager->flush();

    }
}

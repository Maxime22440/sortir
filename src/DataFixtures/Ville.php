<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class Ville extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        // $product = new Product();
        // $manager->persist($product);

        $rennes = new \App\Entity\Ville();
        $rennes->setNom("Rennes");
        $rennes->setCodePostal("35000");


        $manager->persist($rennes);
        $manager->flush();
        $this->addReference('Rennes', $rennes);
    }
}

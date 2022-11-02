<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class Campus extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        // $product = new Product();
        // $manager->persist($product);
        $chartresDeBretagne = new \App\Entity\Campus();
        $chartresDeBretagne->setNom('Chartres-de-Bretagne');
        $manager->persist($chartresDeBretagne);
        $this->addReference('Chartres-de-Bretagne', $chartresDeBretagne);



        $manager->flush();
    }
}

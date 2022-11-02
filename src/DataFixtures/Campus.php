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

        $nantes = new \App\Entity\Campus();
        $nantes->setNom('Nantes');
        $manager->persist($nantes);
        $this->addReference('Nantes', $nantes);

        $quimper = new \App\Entity\Campus();
        $quimper->setNom('Quimper');
        $manager->persist($quimper);
        $this->addReference('Quimper', $quimper);

        $niort = new \App\Entity\Campus();
        $niort->setNom('Niort');
        $manager->persist($niort);
        $this->addReference('Niort', $niort);


        $manager->flush();
    }
}

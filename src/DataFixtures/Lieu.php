<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class Lieu extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
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
        $manager->flush();


    }

    public function getDependencies()
    {
        return[
            Ville::class,
        ];
    }
}

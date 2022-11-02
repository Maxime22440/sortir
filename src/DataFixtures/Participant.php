<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class Participant extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        // $product = new Product();
        // $manager->persist($product);
        $roman = new \App\Entity\Participant();
        $roman->setNom('Sueur');
        $roman->setMail('roman@gmail.com');
        $roman->setMotDePasse('azerty');
        $roman->setTelephone('06 56 44 21 78');
        $roman->setActif(true);
        $roman->addSortiesInscrit();
        $roman->addSortiesOrganisee();
        $roman->setCampus($this->getReference('Chartres-de-Bretagne'));
        $manager->persist($roman);
        $this->addReference('roman', $roman);

        $manager->flush();
    }
}

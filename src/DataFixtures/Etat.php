<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class Etat extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        // $product = new Product();
        // $manager->persist($product);
        $enCours = new \App\Entity\Etat();
        $enCours->setLibelle('En Cours');
        $manager->persist($enCours);
        $this->addReference('En Cours', $enCours);

        $ferme = new \App\Entity\Etat();
        $ferme->setLibelle('Fermé');
        $manager->persist($ferme);
        $this->addReference('Fermé', $ferme);

        $ouvert = new \App\Entity\Etat();
        $ouvert->setLibelle('Ouvert');
        $manager->persist($ouvert);
        $this->addReference('Ouvert', $ouvert);

        $enCreation = new \App\Entity\Etat();
        $enCreation->setLibelle('En Création');
        $manager->persist($enCreation);
        $this->addReference('En Création', $enCreation);

        $annulee = new \App\Entity\Etat();
        $annulee->setLibelle('Annulée');
        $manager->persist($annulee);
        $this->addReference('Annulée', $annulee);


        $manager->flush();
    }
}

<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class Sortie extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        // $product = new Product();
        // $manager->persist($product);
        $sortiePiscine = new \App\Entity\Sortie();
        $sortiePiscine->setNom('sortiePiscine');
        $sortiePiscine->setDateHeureDebut(new \DateTime('2023-01-10 09:15:35'));
        $sortiePiscine->setDuree(3600);
        $sortiePiscine->setDateLimiteInscription(new \DateTime('2023-01-15 09:15:35'));
        $sortiePiscine->setNbInscriptionsMax(20);
        $sortiePiscine->setInfosSortie('on va trop se marrer');
        $sortiePiscine->setEtat($this->getReference('Ouvert'));
        $sortiePiscine->setOrganisateur($this->getReference('roman'));
        $sortiePiscine->addParticipantsInscrit($this->getReference('roman'));
        $sortiePiscine->setCampus($this->getReference('Chartres-de-Bretagne'));
        $sortiePiscine->setLieu($this->getReference('Mairie de Rennes'));
        $manager->persist($sortiePiscine);
        $manager->flush();
        $this->addReference('sortiePiscine', $sortiePiscine);
    }

    public function getDependencies()
    {
        return[
            Lieu::class,
        ];
    }
}

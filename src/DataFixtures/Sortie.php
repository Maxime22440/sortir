<?php

namespace App\DataFixtures;

use App\DataFixtures\Etat;

use App\DataFixtures\Campus;
use App\DataFixtures\Lieu;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

use Faker;





class Sortie extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        $faker = Faker\Factory::create('fr_FR');

        $organisateur = $manager->getRepository(\App\Entity\Participant::class)->findAll();
        $etats = $manager->getRepository(\App\Entity\Etat::class)->findAll();
        $lieu = $manager->getRepository(\App\Entity\Lieu::class)->findAll();
        $campus = $manager->getRepository(\App\Entity\Campus::class)->findAll();

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

        $sorties = array();
        for($i=0;$i<50;$i++){
        $sorties[$i] = new \App\Entity\Sortie();
        $sorties[$i]->setNom($faker->sentence(3));
        $sorties[$i]->setDateHeureDebut($faker->dateTimeBetween('-3 months', '+3 months'));
        $intervalleDebut = clone $sorties[$i]->getDateHeureDebut();
        $intervalleDebut = date_sub($intervalleDebut, new \DateInterval('P5D'));
        $sorties[$i]->setDateLimiteInscription($faker->dateTimeBetween($intervalleDebut, $sorties[$i]->getDateHeureDebut()));
        $sorties[$i]->setDuree($faker->numberBetween(10,200));
        $sorties[$i]->setInfosSortie($faker->paragraph);
        $sorties[$i]->setNbInscriptionsMax($faker->numberBetween(1,10));
            $sorties[$i]->setCampus($faker->randomElement($campus));
        $sorties[$i]->setEtat($faker->randomElement($etats));
        $sorties[$i]->setOrganisateur($faker->randomElement($organisateur));
        $sorties[$i]->addParticipantsInscrit($faker->randomElement($organisateur));
        $sorties[$i]->setLieu($faker->randomElement($lieu));


        $manager->persist($sorties[$i]);
        $manager->flush();


        }

    }

    public function getDependencies()
    {
        return[
            Lieu::class,
        ];
    }
}

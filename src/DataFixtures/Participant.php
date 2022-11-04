<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class Participant extends Fixture
{
    public function __construct(private UserPasswordHasherInterface $hasher)
    {
    }

    public function load(ObjectManager $manager): void
    {
        // $product = new Product();
        // $manager->persist($product);
        $roman = new \App\Entity\Participant();
        $roman->setNom('Sueur');
        $roman->setUsername('roro');
        $roman->setPrenom('roman');
        $roman->setMail('roman@gmail.com');
       $roman->setPassword($this->hasher->hashPassword($roman, 'roman'));
        $roman->setTelephone('06 56 44 21 78');
        $roman->setActif(true);
        $roman->setCampus($this->getReference('Chartres-de-Bretagne'));
        $manager->persist($roman);
        $this->addReference('roman', $roman);

        $maxime = new \App\Entity\Participant();
        $maxime->setNom('rousseau');
        $maxime->setUsername('meeter');
        $maxime->setPrenom('maxime');
        $maxime->setMail('maxime.rousseau99@gmail.com');
        $maxime->setPassword($this->hasher->hashPassword($maxime, 'maxime'));
        $maxime->setTelephone('07 81 72 66 21');
        $maxime->setActif(true);
        $maxime->setCampus($this->getReference('Nantes'));
        $manager->persist($maxime);
        $this->addReference('maxime', $maxime);

        $manager->flush();
    }
}

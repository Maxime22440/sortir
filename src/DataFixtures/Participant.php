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

        $manager->flush();
    }
}

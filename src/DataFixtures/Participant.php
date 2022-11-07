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

        $thibaut = new \App\Entity\Participant();
        $thibaut->setNom('jolivet');
        $thibaut->setUsername('titi');
        $thibaut->setPrenom('thibaut');
        $thibaut->setMail('jolivet.thibaut979@gmail.com');
        $thibaut->setPassword($this->hasher->hashPassword($thibaut, 'thibaut'));
        $thibaut->setTelephone('07 83 10 22 77');
        $thibaut->setActif(true);
        $thibaut->setCampus($this->getReference('Quimper'));
        $manager->persist($thibaut);
        $this->addReference('thibaut', $thibaut);



        for($i=0;$i<100;$i++){
            $user = new \App\Entity\Participant();
            $user->setNom('Henry');
            $user->setPrenom('Dess');
            $user->setUsername('user'.$i);
            $user->setMail('bonjour.aurevoir@cordialement.com');
            $user->setPassword('123');
            $user->setTelephone('0102030400');
            $user->setActif(true);
            $user->setCampus($this->getReference('Chartres-de-Bretagne'));
            $manager->persist($user);

        }


        $manager->flush();
    }
}

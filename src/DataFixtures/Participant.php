<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Faker;

 use Doctrine\Bundle\FixturesBundle\FixtureGroupInterface;

class Participant extends Fixture
{

    public function __construct(private UserPasswordHasherInterface $hasher)
    {
    }


    public function load(ObjectManager $manager): void
    {
        $faker = Faker\Factory::create('fr_FR');

        // $product = new Product();
        // $manager->persist($product);
        $roman = new \App\Entity\Participant();
        $roman->setNom('Turing');
        $roman->setUsername('mrt');
        $roman->setPrenom('alan');
        $roman->setMail('mrt@email.com');
        $roman->setPassword($this->hasher->hashPassword($roman, 'mrt123'));
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



        for($i=0;$i<30;$i++){
            $user = new \App\Entity\Participant();
            $user->setNom($faker->lastName);
            $user->setPrenom($faker->firstName);
            $user->setUsername($faker->userName);
            $user->setMail($faker->email);
            $user->setPassword($this->hasher->hashPassword($user, 'faker'));
            $user->setTelephone($faker->phoneNumber);
            $user->setActif(true);
            if ($i % 2==0) $user->setCampus($this->getReference('Chartres-de-Bretagne'));
            else  $user->setCampus($this->getReference('Nantes'));
            $manager->persist($user);

        }


        $manager->flush();
    }


}

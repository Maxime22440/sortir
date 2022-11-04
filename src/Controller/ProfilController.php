<?php

namespace App\Controller;

use App\Entity\Participant;
use App\Form\ProfilFormType;
use App\Repository\CampusRepository;
use App\Repository\ParticipantRepository;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Exception\ORMException;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;


class ProfilController extends AbstractController
{


    /**
     * @throws OptimisticLockException
     * @throws ORMException
     */
    #[Route('/profil', name: 'app_profil',methods: ['GET', 'POST'])]
    public function update(Request $request,CampusRepository $campusRepository,UserPasswordHasherInterface $hasher, ParticipantRepository $participantRepository, EntityManagerInterface $em): Response
    {


        $user = $this->getUser();



        $profilForm = $this->createForm(profilFormType::class, $user);
        $profilForm->handleRequest($request);


        if ($profilForm->isSubmitted() && $profilForm->isValid()) {



            $newPassword = $profilForm->get('password2')->getData();

            //$encoded = $hasher->hashPassword($user,$newPassword);
           // $user->setPassword($encoded);
            //$participantRepository->save($user);


            $user->setPassword(
                $hasher->hashPassword(
                    $user,
                    $newPassword

                )
            );
            $em->persist($user);
            $em->flush();

            $this->addFlash('success', 'Le profil a bien été modifié');

            return $this->redirectToRoute('app_sorties');
        }

        return $this->render('profil/profil.html.twig', [
            'profilForm' => $profilForm->createView(),
            'campus' => $campusRepository
        ]);
    }



}
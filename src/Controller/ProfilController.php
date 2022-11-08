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

            if($profilForm->get('password2')->isEmpty()){
                $user->setPassword($user->getPassword());
            }
            else{
                $newPassword = $profilForm->get('password2')->getData();





                $user->setPassword(
                    $hasher->hashPassword(
                        $user,
                        $newPassword

                    )
                );
            }

            $em->persist($user);
            $em->flush();

            $this->addFlash('success', 'Le profil a bien été modifié');

            return $this->redirectToRoute('app_profil_affichage');
        }

        return $this->render('profil/profil.html.twig', [
            'profilForm' => $profilForm->createView(),
            'campus' => $campusRepository
        ]);
    }

    #[Route('/profilAffichage', name: 'app_profil_affichage')]
    public function SelectProfil(Request $request,CampusRepository $campusRepository , EntityManagerInterface $em): Response
    {






        return $this->render('profil/affichageProfil.html.twig', [

            'campus' => $campusRepository
        ]);
    }
    #[Route('/profilAutreUtilisateur/{id}', name: 'app_other_profil_affichage',requirements: ['id' => '\d+'])]
    public function SelectOtherProfile(CampusRepository $campusRepository, ParticipantRepository $participantRepository , int $id): Response
    {


        $utilisateur = $participantRepository->find($id);

        if ($utilisateur === null) {
            throw $this->createNotFoundException('Page not found');
        }

        return $this->render('profil/affichageProfilAutreUtilisateur.html.twig', [

            'campus' => $campusRepository,
            'user' => $utilisateur
        ]);
    }


}
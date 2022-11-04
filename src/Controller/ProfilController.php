<?php

namespace App\Controller;

use App\Entity\Participant;
use App\Form\ProfilFormType;
use App\Repository\CampusRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


class ProfilController extends AbstractController
{

//    #[Route('/profil', name: 'app_profil')]
//    public function profil(CampusRepository $campusRepository): Response
//    {
//        $profil =new Participant();
//
//        $profilForm = $this->createForm(ProfilFormType::class, $this->getUser());
//
//        if ($profilForm->isSubmitted() && $profilForm->isValid()) {
//
//
//            $em->persist($profil);
//            $em->flush();
//
//            return $this->redirectToRoute('app_sorties');
//        }
//
//        return $this->render('profil/profil.html.twig', [
//            'profilForm' => $profilForm->createView()
//        ]);
//    }


    #[Route('/profil', name: 'app_profil')]
    public function update(CampusRepository $em, Participant $participant): Response
    {
        $profilForm = $this->createForm(profilFormType::class, $participant);

        if ($profilForm->isSubmitted() && $profilForm->isValid()) {

            $em->flush();

            $this->addFlash('success', 'Le profil a bien été modifié');

            return $this->redirectToRoute('app_sorties');
        }

        return $this->render('profil/profil.html.twig', [
            'participant' => $participant,
            '$profilForm' => $profilForm->createView()
        ]);
    }

}
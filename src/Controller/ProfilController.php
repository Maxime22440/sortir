<?php

namespace App\Controller;

use App\Repository\CampusRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


class ProfilController extends AbstractController
{
    #[Route('/profil', name: 'app_profil')]
    public function profil(CampusRepository $campusRepository): Response
    {
        $user = $this->getUser();
        $campus = $campusRepository->findAll();
        return $this->render('profil/profil.html.twig', [
            'controller_name' => 'ProfilController',
            'user' => $user,
            'ListesCampus' => $campus,
        ]);



    }
}
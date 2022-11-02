<?php

namespace App\Controller;

use App\DataFixtures\Sortie;
use App\Repository\SortieRepository;
use Doctrine\ORM\Tools\Pagination\Paginator;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class SortiesController extends AbstractController
{
    #[Route('/sorties', name: 'app_sorties')]
    public function index(SortieRepository $sortieRepository): Response
    {

        $products = $sortieRepository->findAll();
        $user = $this->getUser();

        return $this->render('sorties/sorties.html.twig', [
            'controller_name' => 'LoginController',
            'listes' => $products,
            'user' => $user,
        ]);



    }



}

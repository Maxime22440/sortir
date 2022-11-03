<?php

namespace App\Controller;

use App\DataFixtures\Sortie;
use App\Entity\Etat;
use App\Form\CreateNewFormType;
use App\Form\modele\formModele;
use App\Repository\SortieRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Tools\Pagination\Paginator;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
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


    #[Route('/sorties/detail/{id}', name: 'app_detail_sortie',requirements: ['id' => '\d+'])]
    public function detail(SortieRepository $sortieRepository, int $id): Response
    {
        // Récupérer la sortie à afficher en base de données
        $sortie = $sortieRepository->find($id);

        if ($sortie === null) {
            throw $this->createNotFoundException('Page not found');
        }

        return $this->render('sortie/detail.html.twig', [
            'sortie' => $sortie
        ]);
    }


    #[Route('/sorties/createNew',name:'createNew')]
    public function creationNouvelleSortie(Request $request, EntityManagerInterface $em):Response
    {


        $user = $this->getUser();
        $sortie = new \App\Entity\Sortie();
        $etat = new Etat();
        $etat->setLibelle('Ouvert');
        //remplir les champs lieu, campus, organisateur, participants incscrits, etat
        $sortie->setOrganisateur($user);
        $sortie->addParticipantsInscrit($user);
        $sortie->setEtat($etat);


        $sortieForm = $this->createForm(CreateNewFormType::class,$sortie);


        //récupération si il y a des données
        $sortieForm->handleRequest($request);


        if($sortieForm->isSubmitted() && $sortieForm->isValid()){


            $em->persist($sortie);
            $em->flush();

            $this->addFlash('success','La sortie a été créée');

            return $this->redirectToRoute('app_sorties');

        }

        return $this->render('sorties/createNew.html.twig', [
            'sortieForm' => $sortieForm->createView()
        ]);

    }



}

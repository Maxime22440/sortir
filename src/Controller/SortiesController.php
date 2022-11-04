<?php

namespace App\Controller;

use App\DataFixtures\Sortie;
use App\Entity\Campus;
use App\Form\FilterType;
use App\Form\modele\Filter;
use App\Form\modele\SortiesType;
use App\Repository\CampusRepository;
use App\Entity\Etat;
use App\Form\CreateNewFormType;
use App\Form\modele\formModele;
use App\Repository\SortieRepository;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Tools\Pagination\Paginator;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class SortiesController extends AbstractController
{
    #[Route('/sorties', name: 'app_sorties')]
    public function index(SortieRepository $sortieRepository, CampusRepository $campusRepository, Request $request): Response

    {
        $filter = new Filter();
        $listes = $sortieRepository->findAll();
        $campus = $campusRepository->findAll();
        $user = $this->getUser();

       $userId = $user->getId();

        $filterForm = $this->createForm(FilterType::class,$filter);
        $filterForm->handleRequest($request);

        $filtreData = new Filter();
            $filtreData->setCampus($filterForm->getData()->getCampus());
            $filtreData->setRecherche($filterForm->getData()->getRecherche());
            $filtreData->setFirstdate($filterForm->getData()->getFirstdate());
            $filtreData->setSecondDate($filterForm->getData()->getSecondDate());
            $filtreData->setSortieOrganisateur($filterForm->getData()->getSortieOrganisateur());
            $filtreData->setSortieInscrit($filterForm->getData()->getSortieInscrit());
            $filtreData->setSortieNonInscrit($filterForm->getData()->getSortieNonInscrit());
            $filtreData->setSortiesPasses($filterForm->getData()->getSortiesPasses());

        if ($filterForm->isSubmitted() && $filterForm->isValid()) {
            dump($sortieRepository->findWithFilter($filtreData,$userId));
            $listes = $sortieRepository->findWithFilter($filtreData,$userId);

            dump($listes);
            return $this->render('sorties/sorties.html.twig', [
                'controller_name' => 'LoginController',
                'listes' => $listes,
                'user' => $user,
                'filterForm' => $filterForm->createView(),

            ]);

        }




        return $this->render('sorties/sorties.html.twig', [
            'controller_name' => 'LoginController',
            'listes' => $listes,
            'user' => $user,
            'ListesCampus' => $campus,
            'filterForm' => $filterForm->createView(),

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

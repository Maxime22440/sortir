<?php

namespace App\Controller;

use App\DataFixtures\Sortie;
use App\Entity\Campus;
use App\Form\CancelFormType;
use App\Form\FilterType;
use App\Form\modele\Filter;
use App\Form\modele\SortiesType;
use App\Repository\CampusRepository;
use App\Entity\Etat;
use App\Form\CreateNewFormType;
use App\Form\modele\formModele;
use App\Repository\EtatRepository;
use App\Repository\LieuRepository;
use App\Repository\SortieRepository;
use Container0vTxDus\getCampusRepositoryService;
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

        $campus = $campusRepository->findAll();
        $user = $this->getUser();

        $userId = $user->getId();

        $filterForm = $this->createForm(FilterType::class, $filter);
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
       $listes= $sortieRepository->findWithFilter($filtreData, $userId);

        if ($filterForm->isSubmitted() && $filterForm->isValid()) {

            $listes = $sortieRepository->findWithFilter($filtreData, $userId);


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


    #[Route('/sorties/detail/{id}', name: 'app_detail_sortie', requirements: ['id' => '\d+'])]
    public function detail(SortieRepository $sortieRepository, int $id): Response
    {
        // Récupérer la sortie à afficher en base de données
        $sortie = $sortieRepository->find($id);
       $listeParticipant = $sortie->getParticipantsInscrits();

        if ($sortie === null) {
            throw $this->createNotFoundException('Page not found');
        }

        return $this->render('sorties/detail.html.twig', [
            'sortie' => $sortie,
            'listeParticipant' => $listeParticipant
        ]);
    }


    #[Route('/sorties/createNew', name: 'createNew')]
    public function creationNouvelleSortie(Request $request, EntityManagerInterface $em, EtatRepository $etatRepository): Response
    {


        $user = $this->getUser();
        $sortie = new \App\Entity\Sortie();

        $campus = new Campus();


        //remplir les champs lieu, campus, organisateur, participants incscrits, etat
        $sortie->setOrganisateur($user);
        $sortie->addParticipantsInscrit($user);


        $sortieForm = $this->createForm(CreateNewFormType::class, $sortie);


        //récupération si il y a des données
        $sortieForm->handleRequest($request);


        if ($sortieForm->isSubmitted() && $sortieForm->isValid()) {


            if ($sortieForm->get('Enregistrer')->isClicked()) {


                //requeter le bon état en base et le setter manuellement
                $etat = $etatRepository->findOneBy(['libelle'=>'En Création']);
                $sortie->setEtat($etat);

                $sortie->setEtat($etat);
                $nomSortie = $sortie->getNom();


                $em->persist($sortie);
                $em->flush();

                $this->addFlash('success', "La sortie $nomSortie a été créée");

                return $this->redirectToRoute('app_sorties');

            }

            if ($sortieForm->get('Enregistrer_et_publier')->isClicked()) {

                $etat = $etatRepository->findOneBy(['libelle'=>'ouvert']);
                $sortie->setEtat($etat);

                $nomSortie = $sortie->getNom();
                $em->persist($sortie);
                $em->flush();

                $this->addFlash('success', "La sortie $nomSortie a été créée");

                return $this->redirectToRoute('app_sorties');

            }


        }

        return $this->render('sorties/createNew.html.twig', [
            'sortieForm' => $sortieForm->createView()
        ]);

    }


    #[Route('/sorties/ListeLieuxDUneVille/{id}', name: 'apiVilles')]
    public function ListeLieuxDUneVille(Request $request, EntityManagerInterface $em, LieuRepository $lieuRepository, int $id = 0): Response
    {

//        $ville = $villeRepository->createQueryBuilder("q")
//            ->where("q.ville = :villeId")
//            ->setParameter("villeId", $id)
//            ->getQuery()
//            ->getResult();  On ne fait pas de querybuilder dans les controlleurs. On utilise les méthodes du repository comme ci-dessous

        $lieux = $lieuRepository->findBy(['ville' => $id]);

//        dd($lieux);

//        $responseArray = [];
//        foreach($lieux as $lieu){
//            $responseArray[] = [
//                "id"=>$ville->getId(),
//                "name"=>$ville->getName()
//            ];
//        }  Méthode dépréciée. Utiliser plutot les annotations #[Groups(['nomDuGroupe'])] directement dans les entités.

        return $this->json($lieux, 200, [], ['groups' => 'lieuxDUneVille']); //Dans le quatrième paramètre on peut passer un tableau d'annotations diverses

    }


        #[Route('/sorties/inscription/{id}', name: 'inscription', requirements: ['id' => '\d+'])]
    public function inscription(Request $request, EntityManagerInterface $em, SortieRepository $sortieRepository, int $id): Response
    {

        $user = $this->getUser();
        $sortieAModifier = $sortieRepository->find($id);
        $user->addSortiesParticipe($sortieAModifier);
        $sortieAModifier->addParticipantsInscrit($user);

        $em->persist($sortieAModifier);
        $em->persist($user);
        $em->flush();
        $nomsortie = $sortieAModifier->getNom();

        $this->addFlash('success', "Vous vous êtes inscrit à la sortie $nomsortie!");
        return $this->redirectToRoute('app_sorties');
    }

    #[Route('/sorties/desistement/{id}', name: 'desistement', requirements: ['id' => '\d+'])]
    public function desistement(Request $request, EntityManagerInterface $em, SortieRepository $sortieRepository, int $id): Response
    {

        $user = $this->getUser();
        $sortieAModifier = $sortieRepository->find($id);
        $user->removeSortiesParticipe($sortieAModifier);
        $sortieAModifier->removeParticipantsInscrit($user);

        $em->persist($sortieAModifier);
        $em->persist($user);
        $em->flush();

        $nomsortie = $sortieAModifier->getNom();

        $this->addFlash('success', "Vous vous êtes désinscrit de la sortie $nomsortie !");
        return $this->redirectToRoute('app_sorties');
    }


    #[Route('/sorties/annulation/{id}', name: 'ecranAnnulation', requirements: ['id' => '\d+'])]
    public function annulation(Request $request, EntityManagerInterface $em, SortieRepository $sortieRepository, int $id, EtatRepository $etatRepository): Response
    {


        $cancelForm = $this->createForm(CancelFormType::class);
        $sortieAAnnuler = $sortieRepository->find($id);
        $nomsortie = $sortieAAnnuler->getNom();

        $cancelForm->handleRequest($request);

        if ($cancelForm->isSubmitted() && $cancelForm->isValid()) {
            if ($cancelForm->get('annulerSortie')->isClicked()) {

                $infos = $sortieAAnnuler->getInfosSortie();
                $motif = $cancelForm->getData();
                $infos.= "\n\nMalheureusement cette sortie a dû être annulée pour le motif suivant : ";
                $infos.= $motif['infosSortie'];
                $etatAnnulee = $etatRepository->findOneBy(['libelle'=>'Annulée']);
                $sortieAAnnuler->setEtat($etatAnnulee);

                $sortieAAnnuler->setInfosSortie($infos);


                $em->persist($sortieAAnnuler);
                $em->flush();

                $this->addFlash('success', "La sortie $nomsortie a été annulée.");

                return $this->redirectToRoute('app_sorties');

            }

            if ($cancelForm->get('garderSortie')->isClicked()) {


                $this->addFlash('success', 'Vous n\'avez PAS annulé de sortie');
                return $this->redirectToRoute('app_sorties');

            }

        }

            return $this->render('sorties/confirmationAnnulationSortie.html.twig', [
                'cancelForm' => $cancelForm->createView(),
                'sortie' => $sortieAAnnuler
            ]);




    }
    #[Route('/sorties/publier/{id}', name: 'publier', requirements: ['id' => '\d+'])]
    public function publier(Request $request, EntityManagerInterface $em, EtatRepository $etatRepository,int $id, SortieRepository $sortieRepository): Response
    {


        $user = $this->getUser();
        $sortie = $sortieRepository->find($id);
        if ($sortie === null) {
            throw $this->createNotFoundException('Page not found');
        }

        //remplir les champs lieu, campus, organisateur, participants incscrits, etat
        $sortie->setOrganisateur($user);
        $sortie->addParticipantsInscrit($user);


                $etat = $etatRepository->findOneBy(['libelle'=>'ouvert']);
                $sortie->setEtat($etat);

                $nomSortie = $sortie->getNom();
                $em->persist($sortie);
                $em->flush();

                $this->addFlash('success', "La sortie $nomSortie a été publiée");

                return $this->redirectToRoute('app_sorties');








    }


}

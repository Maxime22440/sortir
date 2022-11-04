<?php

namespace App\Repository;

use App\Entity\Sortie;
use App\Form\modele\Filter;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\Tools\Pagination\Paginator;
use Doctrine\Persistence\ManagerRegistry;
use http\Client\Curl\User;
use Symfony\Component\Security\Core\Security;

/**
 * @extends ServiceEntityRepository<Sortie>
 *
 * @method Sortie|null find($id, $lockMode = null, $lockVersion = null)
 * @method Sortie|null findOneBy(array $criteria, array $orderBy = null)
 * @method Sortie[]    findAll()
 * @method Sortie[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SortieRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Sortie::class);
    }

    public function save(Sortie $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Sortie $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }



    public function findWithFilter(Filter $filter,  $userId )
    {


       $campusId = $filter->getCampus()->getId();
       $recherche = $filter->getRecherche();
       $premiereDate = $filter->getFirstdate();
       $deuxiemeDate = $filter->getSecondDate();
       $sortieOrganisateur = $filter->getSortieOrganisateur();
       $sortieInscrit = $filter->getSortieInscrit();
       $sortieNonInscrit = $filter->getSortieNonInscrit();
       $sortiesPasses = $filter->getSortiesPasses();
       $localDate =  date("Y-m-d H:i:s");


        $querry = $this->createQueryBuilder('sortie')
            ->addSelect('sortie')
            ->andWhere('sortie.campus = :campus')
            ->setParameter('campus', $campusId);


        if (!$recherche == null){


            $querry->andWhere('sortie.nom = :recherche')
                ->setParameter('recher  che',$recherche);
        }

        if ($sortiesPasses == null){


            $querry->andWhere('sortie.dateHeureDebut BETWEEN :premiereDate AND :deuxiemeDate')
                ->setParameter('premiereDate',$premiereDate)
                ->setParameter('deuxiemeDate',$deuxiemeDate);
        }
        if (!$sortiesPasses == null){


            $querry->andWhere('sortie.dateLimiteInscription <= :LocalDate')
                ->setParameter('LocalDate',$localDate);

        }

        if (!$sortieOrganisateur == null){


            $querry->andWhere('sortie.organisateur = :userId')
                ->setParameter('userId',$userId);

        }

        if ((!$sortieInscrit == null) and ($sortieNonInscrit == null) ){


            $querry->addSelect('sortie')
                ->leftJoin('sortie.participantsInscrits','p')
                ->andWhere('p.id = :userId2')
            ->setParameter('userId2',$userId);
        }
        if ((!$sortieNonInscrit == null) and ($sortieInscrit == null)){


            $querry->addSelect('sortie')
                ->leftJoin('sortie.participantsInscrits','p')
                ->andWhere('p.id NOT IN (:userId3)')
                ->setParameter('userId3',$userId);
        }




        return $querry->getQuery()->getResult();
    }




//    /**
//     * @return Sortie[] Returns an array of Sortie objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('s')
//            ->andWhere('s.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('s.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Sortie
//    {
//        return $this->createQueryBuilder('s')
//            ->andWhere('s.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }

}

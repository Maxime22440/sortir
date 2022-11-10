<?php

namespace App\Repository;

use App\Entity\Etat;
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


    public function findWithFilter(Filter $filter, $userId)
    {





        $querry = $this->createQueryBuilder('sortie')
            ->leftJoin('sortie.participantsInscrits', 'pi')
            ->addSelect('pi')
            ->leftJoin('sortie.campus', 'campus')
            ->addSelect('campus')
            ->leftJoin('sortie.lieu', 'lieu')
            ->addSelect('lieu')
            ->leftJoin('sortie.etat', 'etat')
            ->addSelect('etat')
            ->leftJoin('sortie.organisateur', 'so')
            ->addSelect('so');


        if ($filter->getCampus()) {
            if ($filter->getCampus()->getNom() != 'Sélection Du Campus')
            {  $querry->andWhere('sortie.campus = :campus')
                    ->setParameter('campus', $filter->getCampus());
        }
        }

        if ($filter->getRecherche()) {

            $querry->andWhere('sortie.nom like :recherche')
                ->setParameter('recherche', '%'.$filter->getRecherche().'%');
        }

        if ($filter->getFirstdate()) {
            $querry->andWhere('sortie.dateHeureDebut >= :startdate')
                ->setParameter('startdate', $filter->getFirstdate());
        }

        if ($filter->getSecondDate()) {
            $querry->andWhere('sortie.dateHeureDebut <= :endDate')
                ->setParameter('endDate', $filter->getSecondDate());
        }



        if ($filter->getSortieOrganisateur() and !$filter->getSortieNonInscrit()) {


            $querry->andWhere('sortie.organisateur = :userId')
                ->setParameter('userId', $userId);

        }
        if ($filter->getSortieOrganisateur() and $filter->getSortieNonInscrit()) {


            $querry->andWhere('pi.id  IN (:userId3)')
                ->setParameter('userId3',0);

        }


        if ($filter->getSortieInscrit() and !$filter->getSortieNonInscrit()) {

            $querry->andWhere('pi.id = :user')
                ->setParameter('user', $userId);

        }



        if ($filter->getSortieNonInscrit() and !$filter->getSortieInscrit() ){
            $querry->andWhere('pi.id NOT IN (:userId3)')
                ->setParameter('userId3',$userId);
        }


        if ($filter->getSortieNonInscrit() and $filter->getSortieInscrit() ){
            $querry->andWhere('pi.id  IN (:userId3)')
                ->setParameter('userId3',0);
        }



        if ($filter->getSortiesPasses()){


            $querry->andWhere('etat.libelle IN (:etat)')
                ->setParameter('etat','Fermé');

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

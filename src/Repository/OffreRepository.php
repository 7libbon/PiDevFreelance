<?php

namespace App\Repository;

use App\Entity\Offre;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Offre>
 *
 * @method Offre|null find($id, $lockMode = null, $lockVersion = null)
 * @method Offre|null findOneBy(array $criteria, array $orderBy = null)
 * @method Offre[]    findAll()
 * @method Offre[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class OffreRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Offre::class);
    }
<<<<<<< HEAD
    public function findAllOrderedByApprovedStatut(): array
    {
        return $this->createQueryBuilder('o')
            ->andWhere('o.statut = :statut')
            ->setParameter('statut', 'approuvé')
            ->orderBy('o.echances', 'ASC')
            ->getQuery()
            ->getResult();
    }
=======

>>>>>>> origin/master
//    /**
//     * @return Offre[] Returns an array of Offre objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('o')
//            ->andWhere('o.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('o.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }
<<<<<<< HEAD
//    public function findTopThreeByDemandCount(): array
//    {
//        return $this->createQueryBuilder('o')
//            ->select('o.description, COUNT(d) AS demandCount')
//            ->leftJoin('o.demand', 'd')
//            ->groupBy('o')
//            ->orderBy('demandCount', 'DESC')
//            ->setMaxResults(3)
//            ->getQuery()
//            ->getResult();
//    }
    public function findTopThreeByDemandCount(): array
    {
        return $this->createQueryBuilder('o')
            ->select('o.description, COUNT(d) AS demandCount')
            ->leftJoin('o.demandes', 'd')
            ->groupBy('o')
            ->orderBy('demandCount', 'DESC')
            ->setMaxResults(3)
            ->getQuery()
            ->getResult();
    }
    /**
     * Retourne les offres triées par date d'échéance ascendante.
     *
     * @return array
     */
    public function findAllOrderedByEchancesAsc(): array
    {
        return $this->createQueryBuilder('o')
            ->orderBy('o.echances', 'ASC')
            ->getQuery()
            ->getResult();
    }
=======

>>>>>>> origin/master
//    public function findOneBySomeField($value): ?Offre
//    {
//        return $this->createQueryBuilder('o')
//            ->andWhere('o.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}

<?php

namespace App\Repository;

use App\Entity\Adopter;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Adopter>
 */
class AdopterRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Adopter::class);
    }

    public function findByUserShelters(array $shelterIds): array
    {
        return $this->createQueryBuilder('a')
            ->join('a.adoptions', 'ad')
            ->join('ad.animal', 'an')
            ->where('an.shelter IN (:shelterIds)')
            ->setParameter('shelterIds', $shelterIds)
            ->distinct()
            ->getQuery()
            ->getResult();
    }

//    /**
//     * @return Adopter[] Returns an array of Adopter objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('a')
//            ->andWhere('a.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('a.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Adopter
//    {
//        return $this->createQueryBuilder('a')
//            ->andWhere('a.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}

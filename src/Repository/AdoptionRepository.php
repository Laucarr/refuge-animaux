<?php

namespace App\Repository;

use App\Entity\Adoption;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Adoption>
 */
class AdoptionRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Adoption::class);
    }

    public function findByFilters(string $status = '', int $adopterId = 0, int $animalId = 0, int $shelterId = 0, array $shelterIds = []): array
    {
        if (empty($shelterIds)) {
            return [];
        }
        $qb = $this->createQueryBuilder('a')
        ->join('a.animal', 'an');
        

        if (!empty($shelterIds)) {
            $qb->andWhere('an.shelter IN (:shelterIds)')
            ->setParameter('shelterIds', $shelterIds);
        }

        if ($status !== '') {
            $qb->andWhere('a.status = :status')
            ->setParameter('status', $status);
        }

        if ($adopterId !== 0) {
            $qb->andWhere('a.adopter = :adopterId')
            ->setParameter('adopterId', $adopterId);
        }

        if ($animalId !== 0) {
            $qb->andWhere('a.animal = :animalId')
            ->setParameter('animalId', $animalId);
        }

        if ($shelterId !== 0) {
            $qb->andWhere('an.shelter = :shelterId')
            ->setParameter('shelterId', $shelterId);
        }

        return $qb->getQuery()->getResult();
    }

//    /**
//     * @return Adoption[] Returns an array of Adoption objects
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

//    public function findOneBySomeField($value): ?Adoption
//    {
//        return $this->createQueryBuilder('a')
//            ->andWhere('a.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}

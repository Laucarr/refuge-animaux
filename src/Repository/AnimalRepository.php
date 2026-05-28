<?php

namespace App\Repository;

use App\Entity\Animal;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Animal>
 */
class AnimalRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Animal::class);
    }

    public function findAvailable(): array
    {
        return $this->createQueryBuilder('a')
            ->where('a.status = :status')
            ->setParameter('status', 'disponible')
            ->getQuery()
            ->getResult();
    }

    public function findAvailableByShelter(int $shelterId): array
    {
        return $this->createQueryBuilder('a')
            ->where('a.status = :status')
            ->andWhere('a.shelter = :shelter')
            ->setParameter('status', 'disponible')
            ->setParameter('shelter', $shelterId)
            ->getQuery()
            ->getResult();
    }

    public function findByFilters(string $status = '', string $name = '', int $speciesId = 0, int $shelterId = 0): array
    {
        $qb = $this->createQueryBuilder('a');

        if ($status !== '') {
            $qb->andWhere('a.status = :status')
            ->setParameter('status', $status);
        }

        if ($name !== '') {
            $qb->andWhere('a.name LIKE :name')
            ->setParameter('name', '%' . $name . '%');
        }

        if ($speciesId !== 0) {
            $qb->andWhere('a.species = :speciesId')
            ->setParameter('speciesId', $speciesId);
        }

        if ($shelterId !== 0) {
            $qb->andWhere('a.shelter = :shelterId')
            ->setParameter('shelterId', $shelterId);
        }

        return $qb->getQuery()->getResult();
    }

//    /**
//     * @return Animal[] Returns an array of Animal objects
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

//    public function findOneBySomeField($value): ?Animal
//    {
//        return $this->createQueryBuilder('a')
//            ->andWhere('a.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}

<?php

namespace App\Repository\Doctrine;

use App\Entity\Doctrine\MapSerialization;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method MapSerialization|null find($id, $lockMode = null, $lockVersion = null)
 * @method MapSerialization|null findOneBy(array $criteria, array $orderBy = null)
 * @method MapSerialization[]    findAll()
 * @method MapSerialization[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class MapSerializationRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, MapSerialization::class);
    }

    // /**
    //  * @return MapSerialization[] Returns an array of MapSerialization objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('m')
            ->andWhere('m.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('m.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?MapSerialization
    {
        return $this->createQueryBuilder('m')
            ->andWhere('m.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}

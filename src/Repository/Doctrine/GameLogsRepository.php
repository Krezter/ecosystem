<?php

namespace App\Repository\Doctrine;

use App\Entity\Doctrine\GameLogs;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method GameLogs|null find($id, $lockMode = null, $lockVersion = null)
 * @method GameLogs|null findOneBy(array $criteria, array $orderBy = null)
 * @method GameLogs[]    findAll()
 * @method GameLogs[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class GameLogsRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, GameLogs::class);
    }

    // /**
    //  * @return GameLogs[] Returns an array of GameLogs objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('g')
            ->andWhere('g.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('g.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?GameLogs
    {
        return $this->createQueryBuilder('g')
            ->andWhere('g.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}

<?php

namespace App\Repository;

use App\Entity\InteresJugador;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method InteresJugador|null find($id, $lockMode = null, $lockVersion = null)
 * @method InteresJugador|null findOneBy(array $criteria, array $orderBy = null)
 * @method InteresJugador[]    findAll()
 * @method InteresJugador[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class InteresJugadorRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, InteresJugador::class);
    }

    // /**
    //  * @return InteresJugador[] Returns an array of InteresJugador objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('i')
            ->andWhere('i.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('i.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?InteresJugador
    {
        return $this->createQueryBuilder('i')
            ->andWhere('i.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}

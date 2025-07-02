<?php

namespace App\Repository;

use App\Entity\CharacterClasse;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<CharacterClasse>
 */
class CharacterClasseRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, CharacterClasse::class);
    }

       /**
        * @return CharacterClasse[] Returns an array of CharacterClasse objects
        */
       public function findByCharacter($value): array
       {
           return $this->createQueryBuilder('c')
               ->andWhere('c.character = :val')
               ->setParameter('val', $value)
               ->getQuery()
               ->getResult()
           ;
       }

    //    public function findOneBySomeField($value): ?CharacterClasse
    //    {
    //        return $this->createQueryBuilder('c')
    //            ->andWhere('c.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}

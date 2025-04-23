<?php

namespace App\Repository;

use App\Entity\Classe;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Classe>
 */
class ClasseRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Classe::class);
    }

    public function findAllWithPagination($page, $limit) {
        $qb = $this->createQueryBuilder('b')
            ->setFirstResult(($page - 1) * $limit)
            ->setMaxResults($limit);
        return $qb->getQuery()->getResult();
    }

    //    /**
    //     * @return Classe[] Returns an array of Classe objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('c')
    //            ->andWhere('c.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('c.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findCharacters($value): ?Classe
    //    {
    //        return $this->createQueryBuilder('cl')
    //            ->leftJoin('ch.character', 'ch')
    //            ->leftJoin('ch.character', 'ch', 'WITH', 'cc.character = :val')
    //            ->andWhere('c.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findCharacterClasse($value): ?array
    //    {
    //        return $this->createQueryBuilder('cl')
    //            ->leftJoin('cl.characterClasse', 'cc')
    //            ->andWhere('cc = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }
}

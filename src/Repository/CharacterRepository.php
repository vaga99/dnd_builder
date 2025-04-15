<?php

namespace App\Repository;

use App\Entity\Character;
use App\Entity\Classe;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Character>
 */
class CharacterRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Character::class);
    }

    //    /**
    //     * @return Character[] Returns an array of Character objects
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

       public function findOneById($value): ?Character
       {
           return $this->createQueryBuilder('ch')
               ->andWhere('ch.id = :val')
               ->setParameter('val', $value)
               ->getQuery()
               ->getOneOrNullResult()
           ;
       }

       public function findByClasse(Classe $classe): ?array
       {
            $entityManager = $this->getEntityManager();

            $query = $entityManager->createQuery(
                'SELECT ch, cc
                FROM App\Entity\Character ch
                INNER JOIN ch.characterClasses cc
                WHERE cc.classe = :classe'
            )->setParameter('classe', $classe);

            return $query->getResult();
       }
}

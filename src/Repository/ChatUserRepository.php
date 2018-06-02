<?php

namespace App\Repository;

use App\Entity\ChatUser;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method ChatUser|null find($id, $lockMode = null, $lockVersion = null)
 * @method ChatUser|null findOneBy(array $criteria, array $orderBy = null)
 * @method ChatUser[]    findAll()
 * @method ChatUser[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ChatUserRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, ChatUser::class);
    }

//    /**
//     * @return ChatUser[] Returns an array of ChatUser objects
//     */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('c.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?ChatUser
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}

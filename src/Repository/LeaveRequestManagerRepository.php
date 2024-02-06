<?php

namespace App\Repository;

use App\Entity\LeaveRequestManager;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<LeaveRequestManager>
 *
 * @method LeaveRequestManager|null find($id, $lockMode = null, $lockVersion = null)
 * @method LeaveRequestManager|null findOneBy(array $criteria, array $orderBy = null)
 * @method LeaveRequestManager[]    findAll()
 * @method LeaveRequestManager[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class LeaveRequestManagerRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, LeaveRequestManager::class);
    }

//    /**
//     * @return LeaveRequestManager[] Returns an array of LeaveRequestManager objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('l')
//            ->andWhere('l.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('l.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?LeaveRequestManager
//    {
//        return $this->createQueryBuilder('l')
//            ->andWhere('l.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}

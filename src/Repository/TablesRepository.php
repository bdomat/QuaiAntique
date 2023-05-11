<?php

namespace App\Repository;

use App\Entity\Restaurants;
use App\Entity\Tables;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Tables>
 *
 * @method Tables|null find($id, $lockMode = null, $lockVersion = null)
 * @method Tables|null findOneBy(array $criteria, array $orderBy = null)
 * @method Tables[]    findAll()
 * @method Tables[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TablesRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Tables::class);
    }

    public function save(Tables $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Tables $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }
    public function getTotalGuestsForService(Restaurants $restaurant, \DateTimeInterface $dateTime): int
    {
        $qb = $this->createQueryBuilder('t');

        $dateTime = \DateTime::createFromFormat('Y-m-d H:i:s', $dateTime->format('Y-m-d H:i:s'));
        $end_time = clone $dateTime;
        $end_time->modify('+1 hour'); // Assumption: A service lasts for 1 hour

        $qb->select('SUM(t.reserved_number) as total_guests')
            ->innerJoin('t.reservation', 'r')
            ->where('t.restaurant = :restaurant')
            ->andWhere('r.dateTime >= :start_time')
            ->andWhere('r.dateTime < :end_time')
            ->setParameter('restaurant', $restaurant)
            ->setParameter('start_time', $dateTime)
            ->setParameter('end_time', $end_time);

        return (int)$qb->getQuery()->getSingleScalarResult();
    }

    //    /**
    //     * @return Tables[] Returns an array of Tables objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('t')
    //            ->andWhere('t.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('t.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?Tables
    //    {
    //        return $this->createQueryBuilder('t')
    //            ->andWhere('t.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}

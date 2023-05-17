<?php

namespace App\Repository;

use App\Entity\Reservations;
use App\Entity\Schedules;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Reservations>
 *
 * @method Reservations|null find($id, $lockMode = null, $lockVersion = null)
 * @method Reservations|null findOneBy(array $criteria, array $orderBy = null)
 * @method Reservations[]    findAll()
 * @method Reservations[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ReservationsRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Reservations::class);
    }

    public function save(Reservations $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Reservations $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }
    public function findTotalGuestsForService(\DateTimeInterface $date, Schedules $schedule): int
    {
        $dateStart = \DateTime::createFromFormat('Y-m-d H:i:s', $date->format('Y-m-d') . ' ' . $schedule->getOpeningHour()->format('H:i:s'));
        $dateEnd = \DateTime::createFromFormat('Y-m-d H:i:s', $date->format('Y-m-d') . ' ' . $schedule->getClosingHour()->format('H:i:s'));

        $qb = $this->createQueryBuilder('r')
            ->select('SUM(r.guests_number)')
            ->where('r.date_time BETWEEN :start_time AND :end_time')
            ->setParameter('start_time', $dateStart)
            ->setParameter('end_time', $dateEnd);

        return $qb->getQuery()->getSingleScalarResult() ?: 0;
    }



    //    /**
    //     * @return Reservations[] Returns an array of Reservations objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('r')
    //            ->andWhere('r.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('r.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?Reservations
    //    {
    //        return $this->createQueryBuilder('r')
    //            ->andWhere('r.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}

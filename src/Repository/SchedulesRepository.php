<?php

namespace App\Repository;

use App\Entity\Restaurants;
use App\Entity\Schedules;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Schedules>
 *
 * @method Schedules|null find($id, $lockMode = null, $lockVersion = null)
 * @method Schedules|null findOneBy(array $criteria, array $orderBy = null)
 * @method Schedules[]    findAll()
 * @method Schedules[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SchedulesRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Schedules::class);
    }

    public function save(Schedules $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Schedules $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function isRestaurantOpenAt(Restaurants $restaurant, \DateTimeInterface $dateTime): bool
    {
        $qb = $this->createQueryBuilder('s');

        $qb->where('s.restaurant = :restaurant')
            ->andWhere('s.opening_time <= :time')
            ->andWhere('s.closing_time >= :time')
            ->setParameter('restaurant', $restaurant)
            ->setParameter('time', $dateTime);

        return count($qb->getQuery()->getResult()) > 0;
    }
    public function findScheduleForDateTime(\DateTimeInterface $date_time)
    {
        $dayOfWeek = $date_time->format('l'); // Get the day of the week as a string in English
        $dayOfWeekFrench = $this->convertDayToFrench($dayOfWeek); // Convert the day to French

        $qb = $this->createQueryBuilder('s')
            ->where('s.day = :day')
            ->andWhere('s.opening_hour <= :time')
            ->andWhere('s.closing_hour > :time')
            ->setParameter('day', $dayOfWeekFrench)
            ->setParameter('time', $date_time->format('H:i:s')); // Get the time as a string

        return $qb->getQuery()->getOneOrNullResult();
    }

    private function convertDayToFrench($dayInEnglish)
    {
        $daysInFrench = [
            'Monday'    => 'Lundi',
            'Tuesday'   => 'Mardi',
            'Wednesday' => 'Mercredi',
            'Thursday'  => 'Jeudi',
            'Friday'    => 'Vendredi',
            'Saturday'  => 'Samedi',
            'Sunday'    => 'Dimanche',
        ];

        return $daysInFrench[$dayInEnglish] ?? null;
    }

    //    /**
    //     * @return Schedules[] Returns an array of Schedules objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('s')
    //            ->andWhere('s.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('s.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?Schedules
    //    {
    //        return $this->createQueryBuilder('s')
    //            ->andWhere('s.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}

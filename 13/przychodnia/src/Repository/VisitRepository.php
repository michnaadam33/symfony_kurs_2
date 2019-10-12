<?php


namespace App\Repository;


use App\Entity\Patient;
use App\Entity\Visit;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

class VisitRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Visit::class);
    }


    public function findByPatient(Patient $patient)
    {
        return $this->findBy([
            'patient' => $patient
        ]);
    }

    public function findForNextVisit(\DateTime $dateTimeNow): array
    {
        $startDate = clone $dateTimeNow;
        $startDate = $startDate->add(new \DateInterval('P1D'));
        $endDate = clone $startDate;
        $endDate = $endDate->add(new \DateInterval('PT8H'));

        $qb = $this->createQueryBuilder('visit');
        $qb->where('visit.startDate > :startDate')
            ->andWhere('visit.startDate <= :endDate')
            ->setParameter('startDate', $startDate)
            ->setParameter('endDate', $endDate);

//        var_dump($qb->getQuery()->getSQL());
        //SELECT visit FROM App\Entity\Visit visit WHERE visit.startDate > :startDate AND visit.startDate <= :endDate

        $query = $qb->getQuery();

        return $query->getResult();
    }
}
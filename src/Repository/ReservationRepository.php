<?php
 
namespace App\Repository;
 
use App\Entity\Reservation;
use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
 
/**
 * @extends ServiceEntityRepository<Reservation>
 */
class ReservationRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Reservation::class);
    }
 
    public function findReservationsAVenir(User $user): array
    {
        return $this->createQueryBuilder('r')
            ->join('r.representation', 'rep')
            ->where('r.user = :user')
            ->andWhere('rep.dateRepresentation >= :today')
            ->setParameter('user', $user)
            ->setParameter('today', new \DateTime('today'))
            ->orderBy('rep.dateRepresentation', 'ASC')
            ->getQuery()
            ->getResult();
    }

    public function findAllOrderedByDate(): array
    {
        return $this->createQueryBuilder('r')
            ->join('r.representation', 'rep')
            ->join('rep.spectacle', 's')
            ->join('rep.salle', 'sa')
            ->addSelect('rep', 's', 'sa')
            ->orderBy('rep.dateRepresentation', 'DESC')
            ->getQuery()
            ->getResult();
    }
}

    
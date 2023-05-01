<?php

namespace App\Repository;
use App\Entity\Item;
use App\Entity\Bids;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Bids>
 *
 * @method Bids|null find($id, $lockMode = null, $lockVersion = null)
 * @method Bids|null findOneBy(array $criteria, array $orderBy = null)
 * @method Bids[]    findAll()
 * @method Bids[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class BidsRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Bids::class);
    }

    public function save(Bids $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Bids $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

   public function findLastBidForItem($itemId)
{
    $entityManager = $this->getEntityManager();

    $query = $entityManager->createQuery(
        'SELECT b
        FROM App\Entity\Bids b
        JOIN b.item i
        WHERE i.id = :itemId
        ORDER BY b.amount DESC'
    )->setParameter('itemId', $itemId)
     ->setMaxResults(1);

    return $query->getOneOrNullResult();
}


    public function findCurrentBidForItemByUser(int $itemId, int $userId): ?Bids
{
    return $this->createQueryBuilder('b')
        ->andWhere('b.item = :itemId')
        ->andWhere('b.User = :userId')
        ->setParameter('itemId', $itemId)
        ->setParameter('userId', $userId)
        ->orderBy('b.amount', 'DESC')
        ->setMaxResults(1)
        ->getQuery()
        ->getOneOrNullResult();
}
//    /**
//     * @return Bids[] Returns an array of Bids objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('b')
//            ->andWhere('b.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('b.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Bids
//    {
//        return $this->createQueryBuilder('b')
//            ->andWhere('b.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}

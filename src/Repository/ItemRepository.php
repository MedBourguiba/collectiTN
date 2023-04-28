<?php

namespace App\Repository;

use App\Entity\Item;
use App\Entity\Category;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Item>
 *
 * @method Item|null find($id, $lockMode = null, $lockVersion = null)
 * @method Item|null findOneBy(array $criteria, array $orderBy = null)
 * @method Item[]    findAll()
 * @method Item[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ItemRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Item::class);
    }

    public function save(Item $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Item $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

//    /**
//     * @return Item[] Returns an array of Item objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('i')
//            ->andWhere('i.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('i.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }


public function searchItems($searchTerm)
{
    $qb = $this->createQueryBuilder('i')
        ->andWhere('i.name LIKE :searchTerm ')
        ->setParameter('searchTerm', '%'.$searchTerm.'%')
        ->orderBy('i.id', 'DESC')
        ->getQuery();

    return $qb->getResult();
}

public function advancedSearch($startingTime, $endingTime, $startingPrice, $category)
{
    $qb = $this->createQueryBuilder('i')
        ->where('i.status = 0');
    
    if ($startingTime) {
        $qb->andWhere('i.start_time >= :starting_time')
            ->setParameter('starting_time', $startingTime);
    }

    if ($endingTime) {
        $qb->andWhere('i.end_time <= :ending_time')
            ->setParameter('ending_time', $endingTime);
    }

    if ($startingPrice) {
        $qb->andWhere('i.starting_price >= :starting_price')
            ->setParameter('starting_price', $startingPrice);
    }

    if ($category) {
        $qb->andWhere('i.category = :category')
            ->setParameter('category', $category);
    }

    return $qb->getQuery()->getResult();
}
public function findWonItemsByUser($user)
{
    return $this->createQueryBuilder('i')
        ->join('i.bids', 'b')
        ->andWhere('b.User = :user')
        ->andWhere('i.winner = :winner')
        ->setParameter('user', $user)
        ->setParameter('winner', $user)
        ->getQuery()
        ->getResult();
}

//    public function findOneBySomeField($value): ?Item
//    {
//        return $this->createQueryBuilder('i')
//            ->andWhere('i.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}

<?php

namespace App\EventListener;

use App\Entity\Bid;
use App\Entity\Item;
use Doctrine\ORM\EntityManagerInterface;

class SetWinnerListener
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function postUpdate($args)
    {
        $entity = $args->getObject();

        // Check if the entity is an instance of Item and its status has been updated to "closed"
        if ($entity instanceof Item && $entity->getStatus() == 1) {
            // Retrieve the highest bid for the item
            $highestBid = $this->entityManager
                ->getRepository(Bid::class)
                ->findLastBidForItem($entity);

            // If there are no bids, set the winner to null
            if (!$highestBid) {
                $winner = null;
            } else {
                // Otherwise, set the winner to the bidder of the highest bid
                $winner = $highestBid->getUser();
            }

            // Set the winner of the item
            $entity->setWinner($winner);

            // Persist the changes
            $this->entityManager->persist($entity);
            $this->entityManager->flush();
        }
    }
}

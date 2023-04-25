<?php
namespace App\EventListener;

use Doctrine\ORM\Event\LifecycleEventArgs;
use Doctrine\ORM\Event\PreUpdateEventArgs;
use App\Entity\Item;
use Doctrine\ORM\Mapping\PostUpdate;

class ItemStatusListener
{
    /**
 * @PostUpdate
 */
    public function postUpdate(Item $item, LifecycleEventArgs $args)
    {
        // Check if the endDate field has been updated
        if ($args->hasChangedField('end_time')) {

            $endDate = $item->getEndTime();
            $now = new \DateTime('today');
            
            // If the endDate is in the past, update the status to closed
            if ($endDate <= $now) {
                $item->setStatus(1);
                $entityManager = $args->getEntityManager();
                $entityManager->persist($item);
                $entityManager->flush();
            }
        }
    }
}

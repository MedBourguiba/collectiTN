<?php
namespace App\EventListener;

use Doctrine\ORM\Event\LifecycleEventArgs;
use Doctrine\ORM\Event\PreUpdateEventArgs;
use App\Entity\Item;
use Doctrine\ORM\Mapping\PostUpdate;

class ItemStatusListener
{
  
    public function preUpdate(LifecycleEventArgs $args)
    {
        $entity = $args->getObject();

        if ($entity instanceof Item && $args->hasChangedField('endTime')) {
            $currentTime = new \DateTime();
            $endTime = $entity->getEndTime();

            if ($endTime < $currentTime) {
                $entity->setStatus(1);
            } else {
                $entity->setStatus(0);
            }
        }
    }
}

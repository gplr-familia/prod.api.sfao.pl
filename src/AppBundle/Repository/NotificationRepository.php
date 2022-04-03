<?php

declare(strict_types=1);

namespace AppBundle\Repository;

use AppBundle\Entity\Notification;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;

class NotificationRepository extends ServiceEntityRepository
{
    /**
     * @param Notification $notification
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function confirm(Notification $notification): void
    {
        $entityManager = $this->getEntityManager();

        $notification->setStatus(Notification::STATUS_CONFIRMED);

        $entityManager->persist($notification);
        $entityManager->flush();
    }

    /**
     * @param Notification $notification
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function decline(Notification $notification): void
    {
        $entityManager = $this->getEntityManager();

        $notification->setStatus(Notification::STATUS_DECLINED);

        $entityManager->persist($notification);
        $entityManager->flush();
    }
}
<?php

declare(strict_types=1);

namespace AppBundle\Controller;

use AppBundle\Entity\Notification;
use AppBundle\Repository\NotificationRepository;

class ConfirmNotification
{
    /**
     * @param Notification $notification
     * @param NotificationRepository $repository
     * @return Notification
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function __invoke(Notification $notification, NotificationRepository $repository)
    {
        $repository->confirm($notification);

        return $notification;
    }
}
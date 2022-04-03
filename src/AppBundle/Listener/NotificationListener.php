<?php

declare(strict_types=1);

namespace AppBundle\Listener;

use AppBundle\Entity\Notification;
use AppBundle\Entity\Recommendation;
use DateInterval;
use Doctrine\ORM\Event\LifecycleEventArgs;

final class NotificationListener
{
    /**
     * @param LifecycleEventArgs $args
     * @throws \Exception
     */
    public function postPersist(LifecycleEventArgs $args)
    {
        $entity = $args->getObject();

        if (!$entity instanceof Recommendation) {
            return;
        }

        $entityManager = $args->getEntityManager();

        $notifications = $this->getAllNotifications($entity);

        foreach ($notifications as $notification) {
            $entityManager->persist($notification);
        }

        $entityManager->flush();
    }

    /**
     * @param LifecycleEventArgs $args
     */
    public function preRemove(LifecycleEventArgs $args)
    {
        $entity = $args->getObject();

        if (!$entity instanceof Recommendation) {
            return;
        }

        $qb = $args->getEntityManager()->createQueryBuilder();

        $qb->delete(Notification::class, 'n')
            ->where('n.createdFor = :createdFor')
            ->setParameter('createdFor', '/api/recommendations/' . $entity->getId())
            ->getQuery()
            ->execute();
    }

    public function postUpdate(LifecycleEventArgs $args)
    {
        $entity = $args->getObject();

        if (!$entity instanceof Recommendation) {
            return;
        }

//        $repository = $args->getEntityManager()->getRepository(Notification::class);
//        /** @var Notification[] $notifications */
//        $notifications = $repository->findBy(['createdFor' => '/api/recommendations/' . $entity->getId()]);
    }

    public function getSingleNotification(Recommendation $recommendation, \DateTime $at): Notification
    {
        $notification = new Notification();
        $notification
            ->setUser($recommendation->getUser())
            ->setAt($at)
            ->setCreatedFor('/api/recommendations/' . $recommendation->getId())
            ->setMetadata([
                    'value' => $recommendation->getValue(),
                    'type' => [
                        'name' => $recommendation->getType()->getName(),
                        'unit' => $recommendation->getType()->getUnit()
                    ]
                ]
            )
            ->setStatus(Notification::STATUS_CREATED)
            ->setType(Notification::TYPE_INFO);

        return $notification;
    }

    public function getAllNotifications(Recommendation $recommendation): array
    {
        $notifications = [];

        if ($recommendation->getRecurringFrom() && $recommendation->getRecurringTo() && count($recommendation->getRecurringDayOfWeek())) {
            $start = clone $recommendation->getRecurringFrom();
            $end = clone $recommendation->getRecurringTo();

            while ($start->diff($end)->format('%a') !== '0') {
                if (in_array((int) $start->format('N'), $recommendation->getRecurringDayOfWeek(), true)) {
                    $at = clone $start;
                    $notifications[] = $this->getSingleNotification($recommendation, $at);
                }
                $start->add(new DateInterval('P1D'));
            }

            return $notifications;
        }

        return [$this->getSingleNotification($recommendation, clone $recommendation->getAt())];
    }
}
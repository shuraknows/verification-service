<?php

declare(strict_types=1);

namespace App\Infrastructure\Notification\Persistence;

use App\Domain\Notification\Entity\Notification;
use App\Domain\Notification\Entity\NotificationId;
use App\Domain\Notification\Exception\NotificationNotFoundException;
use App\Domain\Notification\NotificationRepositoryInterface;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class NotificationRepository extends ServiceEntityRepository implements NotificationRepositoryInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Notification::class);
    }

    public function get(NotificationId $notificationId): Notification
    {
        $notification = $this->find($notificationId);

        if (!$notification instanceof Notification) {
            throw new NotificationNotFoundException();
        }

        return $notification;
    }

    public function save(Notification $entity, bool $flush = true): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }
}

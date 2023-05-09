<?php

declare(strict_types=1);

namespace App\Infrastructure\Verification;

use App\Domain\Verification\Entity\Subject\Subject;
use App\Domain\Verification\Entity\Verification;
use App\Domain\Verification\Entity\VerificationId;
use App\Domain\Verification\Exception\Verification\VerificationNotFoundException;
use App\Domain\Verification\VerificationRepositoryInterface;
use DateTimeImmutable;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class VerificationRepository extends ServiceEntityRepository implements VerificationRepositoryInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Verification::class);
    }

    public function get(VerificationId $verificationId): Verification
    {
        $verification = $this->find($verificationId);

        if (!$verification instanceof Verification) {
            throw new VerificationNotFoundException();
        }

        return $verification;
    }

    public function save(Verification $entity, bool $flush = true): void
    {
        // check can be added
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function getConfirmedBySubject(Subject $subject): ?Verification
    {
        return $this->createQueryBuilder('v')
            ->select('v')
            ->where('v.subject.identity.identity = :identity')
            ->andWhere('v.subject.identityType.identityType = :type')
            ->andWhere('v.confirmed.confirmed = :confirmed')
            ->setParameter('identity', (string)$subject->identity())
            ->setParameter('type', (string)$subject->identityType())
            ->setParameter('confirmed', true)
            ->setMaxResults(1)
            ->getQuery()
            ->getOneOrNullResult();
    }

    public function getPendingVerification(Subject $subject, DateTimeImmutable $now = new DateTimeImmutable()): ?Verification
    {
        return $this->createQueryBuilder('v')
            ->select('v')
            ->where('v.subject.identity.identity = :identity')
            ->andWhere('v.subject.identityType.identityType = :type')
            ->andWhere('v.confirmed.confirmed = :confirmed')
            ->andWhere('v.expiresAt.expiresAt >= :now')
            ->setParameter('identity', (string) $subject->identity())
            ->setParameter('type', (string) $subject->identityType())
            ->setParameter('confirmed', false)
            ->setParameter('now', $now)
            ->setMaxResults(1)
            ->getQuery()
            ->getOneOrNullResult();
    }
}

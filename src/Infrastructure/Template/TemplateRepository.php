<?php

declare(strict_types=1);

namespace App\Infrastructure\Template;

use App\Domain\Template\Entity\Slug;
use App\Domain\Template\Entity\Template;
use App\Domain\Template\Exception\TemplateNotFoundException;
use App\Domain\Template\TemplateRepositoryInterface;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class TemplateRepository extends ServiceEntityRepository implements TemplateRepositoryInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Template::class);
    }

    public function save(Template $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Template $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function getBySlug(Slug $slug): Template
    {
        $template = $this->getEntityManager()
            ->createQueryBuilder()
            ->select('t')
            ->from(Template::class, 't')
            ->where('t.slug.slug = :slug')
            ->setParameter('slug', (string)$slug)
            ->setMaxResults(1)
            ->getQuery()
            ->getOneOrNullResult();


        if (!$template instanceof Template) {
            throw new TemplateNotFoundException($slug);
        }

        return $template;
    }
}

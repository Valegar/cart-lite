<?php

namespace App\Repository;

use App\Entity\Product;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Product|null find($id, $lockMode = null, $lockVersion = null)
 * @method Product|null findOneBy(array $criteria, array $orderBy = null)
 * @method Product[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ProductRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Product::class);
    }

    /**
     * @return Product[]
     */
    public function findAll()
    {
        $qb = $this->createQueryBuilder('p');
        $qb->orderBy('p.name');

        return $qb->getQuery()->getResult();
    }

    public function findAllForExport(): array
    {
        $qb = $this->createQueryBuilder('p');
        $qb->orderBy('p.name');

        return $qb->getQuery()->getArrayResult();
    }

    /**
     * @return Product[]
     */
    public function findByIds(array $ids): array
    {
        if (empty($ids)) {
            return [];
        }

        $qb = $this->createQueryBuilder('p');
        $qb->andWhere($qb->expr()->in('p.id', $ids));
        $qb->orderBy('p.name');

        return $qb->getQuery()->getResult();
    }
}

<?php

namespace App\Repository;

use App\Entity\Contents;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Contents>
 *
 * @method Contents|null find($id, $lockMode = null, $lockVersion = null)
 * @method Contents|null findOneBy(array $criteria, array $orderBy = null)
 * @method Contents[]    findAll()
 * @method Contents[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ContentsRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Contents::class);
    }

    public function save(Contents $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Contents $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function search(?array $categories, ?string $search, int $page): array
    {
        $query = $this->createQueryBuilder('c');

        if ($categories) {
            $query->innerJoin('c.categories', 'cat')
                ->andWhere('cat.id IN (:categories)')
                ->setParameter('categories', $categories);
        }

        if ($search) {
            $query->andWhere('c.title LIKE :search OR c.content LIKE :search')
                ->setParameter('search', '%' . $search . '%');
        }

        $count = count($query->getQuery()->getResult());

        $query->orderBy('c.createdAt', 'DESC')
            ->setFirstResult(($page - 1) * 12)
            ->setMaxResults(12);

        return ['count' => $count, 'results' => $query->getQuery()->getResult()];
    }

//    /**
//     * @return Contents[] Returns an array of Contents objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('c')
//            ->andWhere('c.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('c.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Contents
//    {
//        return $this->createQueryBuilder('c')
//            ->andWhere('c.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}

<?php

namespace App\Repository;

use App\Entity\Serie;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\Tools\Pagination\Paginator;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Serie>
 */
class SerieRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Serie::class);
    }

    public function findBestSeries(){
        //les séries les plus populaires trié par popularité
        //en DQL
//        $dql = "SELECT s FROM App\Entity\Serie s
//                WHERE s.popularity > 500
//                ORDER BY s.popularity DESC
//                ";
//        $en = $this->getEntityManager();
//        $query = $en->createQuery($dql);

        //avec QueryBuilder
        $qb = $this->createQueryBuilder('s');
        $qb->andWhere("s.popularity > 500 OR s.overview LIKE :way ")
            ->orderBy('s.popularity', 'DESC')
            ->setParameter('way','%way%');
        $query = $qb->getQuery();

        return $query->getResult();
    }

    public function findBestSeriesWithPagination(int $page){

        $limit = 50;
        $offset = ($page-1)*$limit;
        $qb = $this->createQueryBuilder('s');
        $qb->join('s.seasons', 'se')
            ->addSelect('se')
            ->addOrderBy('s.popularity', 'DESC')
            ->setFirstResult($offset)
            ->setMaxResults($limit)
        ;

        return new Paginator($qb->getQuery());
//        return $qb->getQuery()->getResult();
//        return $this->findBy([], ['popularity' => 'DESC'], $limit, $offset);

    }

}

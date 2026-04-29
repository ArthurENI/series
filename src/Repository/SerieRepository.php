<?php

namespace App\Repository;

use App\Entity\Serie;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
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

}

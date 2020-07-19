<?php

namespace App\Repository;

use App\Entity\CartArticle;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method CartArticle|null find($id, $lockMode = null, $lockVersion = null)
 * @method CartArticle|null findOneBy(array $criteria, array $orderBy = null)
 * @method CartArticle[]    findAll()
 * @method CartArticle[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CartArticleRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, CartArticle::class);
    }

    
  
}

<?php

namespace App\Service;

use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\ORM\EntityManagerInterface;

class CartService {
    private $manager;

    public function __construct(EntityManagerInterface $manager) 
    {
        $this->manager = $manager;
    }

    public function getCart($user)
    {
        return $this->manager->createQuery(
            'SELECT DISTINCT a.articleName, ca.quantity, a.price, a.id
            FROM App\Entity\Article a
            JOIN App\Entity\CartArticle ca
            JOIN App\Entity\User u
            WHERE a.id = ca.article
            AND ca.user = ' .$user
             
            ) 
            ->getResult();
    }

        public function deleteArticleInCart($user, $article)
    {
        return $this->manager->createQuery(
            'DELETE FROM App\Entity\CartArticle ca 
            WHERE ca.user = ' .$user .
            'AND ca.article = ' .$article
            
        )
        ->getResult(); 
        
            
    }
    
    public function updateQuantityInCart($user, $quantity, $article)
    {
        return $this->manager->createQuery(
            'UPDATE App\Entity\CartArticle ca
             SET ca.quantity = ' .$quantity . 
             'WHERE ca.user = '  .$user .
             'AND ca.article  = ' .$article   
             
            ) 
            ->getResult();
    }

}



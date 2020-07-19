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
            'SELECT DISTINCT a.articleName, ca.quantity, a.price
            FROM App\Entity\Article a
            JOIN App\Entity\CartArticle ca
            JOIN App\Entity\User u
            WHERE a.id = ca.article
            AND ca.user = ' .$user
             
            ) 
            ->getResult();
    }


}

//SELECT article_name, cart_article.quantity, first_name, last_name, article.price FROM article INNER JOIN cart_article ON cart_article.article_id = article.id INNER JOIN user ON cart_article.user_id = user.id 
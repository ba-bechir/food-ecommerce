<?php

namespace App\Controller;

use App\Entity\Cart;
use App\Entity\User;
use App\Form\UserType;
use App\Entity\Article;
use App\Repository\ArticleRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Security;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class ProductController extends AbstractController
{
    /**
     * @Route("/products", name="products")
     */
    public function showAllProducts(ArticleRepository $repo)
    {
    
        $articles = $repo->findAll();

        return $this->render('products/products.html.twig', [
            'articles' => $articles,
        ]);
    }

     /**
     * @Route("/products_details/{id}", name="products_details")
     */
    public function showProductDetail(Article $article)
    {

        return $this->render('products/product_detail.html.twig', [
           'article' => $article,
        ]);
    }
}
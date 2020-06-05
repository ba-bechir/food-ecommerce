<?php

namespace App\Controller;

use App\Repository\ArticleRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ClientController extends AbstractController
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
     * @Route("/products_details", name="products_details")
     */
    public function showProductDetail(ArticleRepository $repo)
    {

        return $this->render('products/product_detail.html.twig', [
           // 'articles' => $articles,
        ]);
    }



}

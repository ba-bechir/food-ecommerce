<?php

namespace App\Controller;

use App\Repository\ArticleRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ClientController extends AbstractController
{
    /**
     * @Route("/index", name="index")
     */
    public function showAllArticles(ArticleRepository $repo)
    {
    
        $articles = $repo->findAll();

        return $this->render('client/index.html.twig', [
            'articles' => $articles,
        ]);
    }



}

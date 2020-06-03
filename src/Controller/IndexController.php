<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class IndexController extends AbstractController
{
    /**
     * @Route("/index", name="index")
     */
    public function index()
    {
        return $this->render('index.html.twig', [
            //'controller_name' => 'IndexController',
        ]);
    }

    /**
     * @Route("/home", name="home")
     */
    public function home()
    {
        return new Response("OK");
    }
}

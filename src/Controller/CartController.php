<?php

namespace App\Controller;

use App\Entity\Article;
use App\Repository\ArticleRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class CartController extends AbstractController
{
    /**
     * @Route("/cart", name="cart_index")
     * Afficher le contenu du panier
     */
    public function index(SessionInterface $session,  ArticleRepository $articleRepository)
    {
        $cart = $session->get('cart', []);

        $cartWithData = [];

        //$id : id du produit sauvegardé dans la session
        foreach ($cart as $id => $quantity)
        {
            $cartWithData[] = 
            [
                'product' => $articleRepository->find($id),
                'quantity' => $quantity
            ];
        }

        $total = 0;

        foreach($cartWithData as $item)
        {
            $totalItem = $item['product']->getPrice() * $item['quantity'];
            $total += $totalItem;
        }

        return $this->render('cart/index.html.twig', [
            'items' => $cartWithData,
            'total' => $total
        ]);
    }

     /**
     * @Route("/cart/add/{id}", name="cart_add")
     * Ajout d'articles dans le panier
     */
    public function add(Article $article, SessionInterface $session, ArticleRepository $articleRepository)
    {
       //$articles = $repo->findAll();
    
        /* Récupération du panier
           [] : par défaut, panier vide
        */
        $cart = $session->get('cart', []);

        //Gestion ajout article dans le cart si deja présent
        if(!empty($cart[$article->getId()]))
        {
            $cart[$article->getId()]++;
        } else {
            $cart[$article->getId()] = 1;
        }

        //Affichage
        $session->set('cart', $cart);
        
        return $this->redirectToRoute('cart_index');
        
    }

    /**
     * @Route("/cart/remove/{id}", name="cart_remove")
     * Suppression d'articles dans le panier
     */
    public function remove(Article $article, SessionInterface $session)
    {
        $cart = $session->get('cart', []);

        if(!empty($cart[$article->getId()]))
        {
            unset($cart[$article->getId()]);
        } 

        $session->set('cart', $cart);

        return $this->redirectToRoute('cart_index');
    }
}
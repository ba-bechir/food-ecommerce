<?php

namespace App\Controller;

use App\Entity\Cart;
use App\Entity\User;
use App\Entity\Article;
use App\Entity\CartArticle;
use App\Service\CartService;
use App\Repository\ArticleRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

class CartController extends AbstractController
{
    /**
     * @Route("/cart", name="cart_index")
     * Afficher le contenu du panier
     * A décommenter en cas d'évolution
     */
    public function index(SessionInterface $session,  ArticleRepository $articleRepository, CartService $cartService)
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
     * @IsGranted("ROLE_USER")
     * Ajout d'articles dans le panier
     */
    public function add(Article $article, SessionInterface $session, ArticleRepository $articleRepository, EntityManagerInterface $manager)
    {
          $user = $this->getUser();

          if($_POST['quantity'] > $article->getQuantity())
          {
            $this->addFlash(
                'error',
                'Quantité non disponible en stock ! Retournez vers la page précédente'
                
            );
            
          }

          else {

          $cartArticle = new CartArticle();

          $cartArticle->setUser($user); 
          $cartArticle->setArticle($article);
          
          $cartArticle->setQuantity($_POST['quantity']);
            
          $manager->persist($cartArticle);
          $manager->flush();
            
        }
            
        $articleQuantity = $article->getQuantity();

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
        
        return $this->redirectToRoute('cart_connected', array('id' => $this->getUser()->getId()));
        
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

    
    /**
     * @Route("/cart/{id}", name="cart_connected")
     * @IsGranted("ROLE_USER")
     * Afficher le contenu du panier
     */
    public function showCartConnected(SessionInterface $session,  ArticleRepository $articleRepository, CartService $cartService, User $id)
    {
        $id = $this->getUser()->getId();
        $carts = $cartService->getCart($id);

        $total = 0;
        $article;

            //Total        
            for($i = 0 ; $i < count($carts); $i++)
            {
                $data = $carts[$i]['price'] * $carts[$i]['quantity']; 
                $total += $data;
            }

            
        return $this->render('cart/indexConnected.html.twig', [
            'carts' => $carts,
            'total' => $total
    ]);
    
        }
    }
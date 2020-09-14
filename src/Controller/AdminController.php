<?php

namespace App\Controller;

use App\Entity\User;
use App\Entity\Image;
use App\Entity\Article;
use App\Form\ArticleType;
use App\Form\UserEditType;
use App\Repository\UserRepository;
use App\Repository\ArticleRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class AdminController extends AbstractController
{
    /**
     * @Route("/admin/login", name="account_admin_login")
     */
    public function login(AuthenticationUtils $utils)
    {
        //Recuperation erreur
        $error = $utils->getLastAuthenticationError();
        //Recuperation du dernier nom d'utilisateur envoyé
        $username = $utils->getLastUsername();
       
        return $this->render('admin/login.html.twig', [
            'hasError' => $error !== null,
            'username' => $username
        ]);
    }

    /**
     * @Route("/admin/logout", name="account_admin_logout")
     */
    public function logout()
    {
        
    }

    /**
     * @Route("/admin/products", name="admin_products")
     * @IsGranted("ROLE_ADMIN")
     */
    public function products(ArticleRepository $repo)
    {
        $articles = $repo->findAll();

        return $this->render('admin/products.html.twig', [
            'articles' => $articles,
        ]);
    }

    /**
     * @Route("/admin/new/product/", name="admin_new_products")
     * @IsGranted("ROLE_ADMIN")
     */

    public function newProduct(Request $request, EntityManagerInterface $manager)
    {
        $article = new Article();

        $form = $this->createForm(ArticleType::class, $article);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid())
        {
            //Récupération des images
            $images = $form->get('image')->getData();

            foreach($images as $image)
            {
                //Génération d'un nom de fichier
                $file = md5(uniqid()).'.'. $image->guessExtension();
                //Copie du fichier dans uploads
                $image->move(
                    $this->getParameter('images_directory'),
                    $file
                );
                //Stockage en BDD
                $img = new Image();
                $img->setName($file);
                $article->addImage($img);
            }
            $manager->persist($article);
            $manager->flush();

            return $this->redirectToRoute('admin_products');

        }

        return $this->render('admin/productNew.html.twig', [
            'article' => $article,
            'form' => $form->createView()
        ]);
    
    }

    /**
     * @Route("/admin/edit/product/{id}", name="admin_edit_products")
     * @IsGranted("ROLE_ADMIN")
     */
    public function editProduct(ArticleRepository $repo, Request $request, Article $article, EntityManagerInterface $manager)
    {
        $form = $this->createForm(ArticleType::class, $article);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid())
        {
            //Récupération des images
            $images = $form->get('image')->getData();

            foreach($images as $image)
            {
                //Génération d'un nom de fichier
                $file = md5(uniqid()).'.'. $image->guessExtension();
                //Copie du fichier dans uploads
                $image->move(
                    $this->getParameter('images_directory'),
                    $file
                );
                //Stockage en BDD
                $img = new Image();
                $img->setName($file);
                $article->addImage($img);
            }

            $manager->persist($article);
            $manager->flush();

            $this->addFlash(
                'success',
                "Le produit <strong>{$article->getArticleName()}</strong> a bien été enregistrée !"
            );

            return $this->redirectToRoute('admin_products');
        }

        return $this->render('admin/productEdit.html.twig', [
            'article' => $article,
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/admin/delete/image/{id}", name="admin_delete_products_image", methods={"GET"})

     */
    public function deleteImage(Image $image, Request $request)
    {
        $data = json_decode($request->getContent(), true);
        //Vérification du Token
        if($this->isCsrfTokenValid('get'.$image->getId(), $data['_token']))
        {
            //On récupère le nom de l'image
            $name = $image->getName();
            //On supprime le fichier
            unlink($this->getParameter('images_directory').'/'.$name);

            $em = $this->getDoctrine()->getManager();
            $em->remove($image);
            $em->flush();

            return new JsonResponse(['success' => 1]);
        }
        else {
            return new JsonResponse(['error' => "Token Invalide"], 400);
        }
    } 


    /**
     * @Route("/admin/clients", name="admin_clients")
     */
    public function showClients(UserRepository $repo)
    {
    
        $clients = $repo->findAll();

        return $this->render('admin/clients.html.twig', [
            'clients' => $clients
        ]);
    }

    /**
     * @Route("/admin/clients/edit/{id}", name="admin_clients_edit")
     */
    public function edit(User $user, Request $request, EntityManagerInterface $manager)
    {
        $form = $this->createForm(UserEditType::class, $user);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid())
        {
            $manager->persist($user);
            $manager->flush();

            $this->addFlash(
                'success',
                "Informations mis à jour"
            );
        }

        return $this->render('admin/clientEdit.html.twig', [
            'user' => $user,
            'form' => $form->createView()
        ]);
    }
    
}
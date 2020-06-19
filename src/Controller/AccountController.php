<?php

namespace App\Controller;

use App\Entity\User;
use App\Entity\Article;
use App\Form\UserRegistrationType;
use App\Repository\ArticleRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class AccountController extends AbstractController
{
    /**
     * @Route("/login", name="account_login")
     */
    public function login(AuthenticationUtils $utils)
    {
        //Recuperation erreur
        $error = $utils->getLastAuthenticationError();
        //Recuperation du dernier nom d'utilisateur envoyé
        $username = $utils->getLastUsername();
       
        return $this->render('account/login.html.twig', [
            'hasError' => $error !== null,
            'username' => $username
        ]);
    }

    /**
     * @Route("/logout", name="account_logout")
     */
    public function logout()
    {
        
    }

    /**
     * @Route("/register", name="client_register")
     */
    public function register(Request $request, EntityManagerInterface $manager, UserPasswordEncoderInterface $encoder)
    {
        $user = new User();

        $form = $this->createForm(UserRegistrationType::class, $user);

        //Gestion du formulaire
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid())
        {
            //Encodage du mdp
          $hash = $encoder->encodePassword($user, $user->getHash()); 
          $user->setHash($hash);  
          $manager->persist($user);
          $manager->flush();
          
          $this->addFlash(
              'success',
              "Votre compte a bien été créé."
          );
          
          return $this->redirectToRoute('account_login');
        }

        return $this->render('account/newUser.html.twig', [
            'form' => $form->createView()
        ]);
    }


}

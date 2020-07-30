<?php

namespace App\Controller;

use Symfony\Component\Routing\Annotation\Route;
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
    public function products()
    {
        return $this->render('admin/products.html.twig');
    }
}

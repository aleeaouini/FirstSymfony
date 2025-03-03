<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Attribute\Route;

final class PagesController extends AbstractController
{
    
    #[Route('/pages', name: 'app_pages')]
    public function index()
    {
        return $this->render('pages/index.html.twig',[
            'controller_name' => 'PagesController',
        ]);
    }

    #[Route('/about', name: 'app_about')]
    public function about()
    {
        return $this->render('pages/about.html.twig',[
            'controller_name' => 'PagesController',
        ]);
    }
    #[Route('/voir', name: 'app_voir')]
    public function voir()
    {
        return $this->render('pages/voir.html.twig',[
            'controller_name' => 'PagesController',
        ]);
    }
    //////////////////////////////////////////
    #[Route('/footer', name: 'app_footer')]
    public function footer()
    {
        return $this->render('pages/footer.html.twig',[
            'controller_name' => 'PagesController',
        ]);
    }
    #[Route('/header', name: 'app_header')]
    public function header()
    {
        return $this->render('pages/header.html.twig',[
            'controller_name' => 'PagesController',
        ]);
    }
    #[Route('/signup', name: 'app_signup')]
    public function signup()
    {
        return $this->render('pages/signup.html.twig',[
            'controller_name' => 'PagesController',
        ]);
    }
    
    #[Route('/login', name: 'app_login')]
    public function login()
    {
        return $this->render('pages/login.html.twig',[
            'controller_name' => 'PagesController',
        ]);
    }
    



}

<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Request;
use App\Form\RegistrationFormType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\User; 
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

final class PagesController extends AbstractController

{
    #[Route('/pages', name: 'app_pages')]
    public function index()
    {
        return $this->render('pages/index.html.twig', [
            'controller_name' => 'PagesController',
        ]);
    }

    #[Route('/about', name: 'app_about')]
    public function about()
    {
        return $this->render('pages/about.html.twig', [
            'controller_name' => 'PagesController',
        ]);
    }

    #[Route('/voir', name: 'app_voir')]
    public function voir()
    {
        return $this->render('pages/voir.html.twig', [
            'controller_name' => 'PagesController',
        ]);
    }

    #[Route('/footer', name: 'app_footer')]
    public function footer()
    {
        return $this->render('pages/footer.html.twig', [
            'controller_name' => 'PagesController',
        ]);
    }

    #[Route('/header', name: 'app_header')]
    public function header()
    {
        return $this->render('pages/header.html.twig', [
            'controller_name' => 'PagesController',
        ]);
    }

    #[Route('/register', name: 'app_register')]
public function signup(Request $request, EntityManagerInterface $entityManager, UserPasswordHasherInterface $passwordHasher): Response
{
    $user = new User();
    $registrationForm = $this->createForm(RegistrationFormType::class, $user);

    $registrationForm->handleRequest($request);

    if ($registrationForm->isSubmitted() && $registrationForm->isValid()) {
        $plainPassword = $registrationForm->get('plainPassword')->getData();
        $hashedPassword = $passwordHasher->hashPassword($user, $plainPassword);
        $user->setPassword($hashedPassword);

        $entityManager->persist($user);
        $entityManager->flush();

        return $this->redirectToRoute('app_login');
    }

    return $this->render('registration/register.html.twig', [
        'registrationForm' => $registrationForm->createView(),
    ]);
}


    #[Route('/login', name: 'app_login')]
    public function login()
    {
        return $this->render('security/login.html.twig', [
            'controller_name' => 'PagesController',
        ]);
    }
}

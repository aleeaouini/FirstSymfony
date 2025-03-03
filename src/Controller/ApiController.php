<?php

namespace App\Controller;

use Symfony\Component\Security\Core\Security;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class ApiController extends AbstractController
{
    #[Route('/books', name: 'books',methods: ['GET'])]
    public function getBooks(): Response
    {
        $books = [
            ['id' => 1, 'title' => 'Le Petit Prince', 'author' => 'Antoine de Saint-Exupéry'],
            ['id' => 2, 'title' => '1984', 'author' => 'George Orwell'],
            ['id' => 3, 'title' => 'Les Misérables', 'author' => 'Victor Hugo']
        ];
        return $this->json($books);
    }
    
}

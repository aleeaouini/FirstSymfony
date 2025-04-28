<?php

namespace App\Controller;

use App\Entity\Book;
use App\Entity\CartItem;
use App\Service\CartService; // Ajout du service CartService
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Routing\Annotation\Route;

class BookController extends AbstractController
{
    #[Route('/book', name: 'app_book')]
    public function index(EntityManagerInterface $entityManager): Response
    {
        // Récupérer les 5 premiers livres
        $books = $entityManager->getRepository(Book::class)->findBy([], null, 5);

        return $this->render('book/index.html.twig', [
            'books' => $books,
        ]);
    }

    #[Route('/book/add-to-cart/{id}', name: 'app_add_to_cart')]
    public function addToCart(int $id, EntityManagerInterface $entityManager): Response
    {
        // Vérifie si l'utilisateur est connecté
        $user = $this->getUser();
        if (!$user) {
            return $this->redirectToRoute('app_login'); // Redirige l'utilisateur vers la page de connexion
        }

        // Trouver le livre par son ID
        $book = $entityManager->getRepository(Book::class)->find($id);
        if (!$book) {
            throw $this->createNotFoundException('Le livre demandé n\'existe pas');
        }

        // Vérifier si le livre est déjà dans le panier de l'utilisateur
        $cartItem = $entityManager->getRepository(CartItem::class)
            ->findOneBy(['book' => $book, 'user' => $user]);

        if ($cartItem) {
            // Si le livre est déjà dans le panier, on incrémente la quantité
            $cartItem->setQuantity($cartItem->getQuantity() + 1);
        } else {
            // Sinon, on crée une nouvelle entrée pour ce livre dans le panier
            $cartItem = new CartItem();
            $cartItem->setBook($book);
            $cartItem->setUser($user);
            $cartItem->setQuantity(1);
            $entityManager->persist($cartItem);
        }

        $entityManager->flush();

        // Rediriger vers la page du panier
        return $this->redirectToRoute('app_cart');
    }

    #[Route('/cart', name: 'app_cart')]
    public function cart(EntityManagerInterface $entityManager): Response
    {
        // Récupérer les livres du panier de l'utilisateur
        $user = $this->getUser();
        if (!$user) {
            return $this->redirectToRoute('app_login');
        }

        $cartItems = $entityManager->getRepository(CartItem::class)->findBy(['user' => $user]);

        return $this->render('cart/index.html.twig', [
            'cartItems' => $cartItems,
        ]);
    }

    #[Route('/book/details/{id}', name: 'app_book_details')]
    public function details(int $id, EntityManagerInterface $entityManager): Response
    {
        $book = $entityManager->getRepository(Book::class)->find($id);

        if (!$book) {
            throw $this->createNotFoundException('Le livre demandé n\'existe pas');
        }

        return $this->render('book/details.html.twig', [
            'book' => $book,
        ]);
    }

    // Ajouter une route pour augmenter la quantité d'un livre
    #[Route('/cart/increase-quantity/{id}', name: 'app_increase_quantity')]
    public function increaseQuantity(int $id, EntityManagerInterface $entityManager): Response
    {
        // Vérifie si l'utilisateur est connecté
        $user = $this->getUser();
        if (!$user) {
            return $this->redirectToRoute('app_login'); // Redirige l'utilisateur vers la page de connexion
        }

        // Trouver l'élément du panier par l'ID du livre
        $cartItem = $entityManager->getRepository(CartItem::class)->findOneBy(['book' => $id, 'user' => $user]);

        if ($cartItem) {
            // Si l'élément est trouvé, on incrémente la quantité
            $cartItem->setQuantity($cartItem->getQuantity() + 1);
            $entityManager->flush();
        }

        // Rediriger vers la page du panier
        return $this->redirectToRoute('app_cart');
    }

    // Ajouter une route pour diminuer la quantité d'un livre
    #[Route('/cart/decrease-quantity/{id}', name: 'app_decrease_quantity')]
    public function decreaseQuantity(int $id, EntityManagerInterface $entityManager): Response
    {
        // Vérifie si l'utilisateur est connecté
        $user = $this->getUser();
        if (!$user) {
            return $this->redirectToRoute('app_login'); // Redirige l'utilisateur vers la page de connexion
        }

        // Trouver l'élément du panier par l'ID du livre
        $cartItem = $entityManager->getRepository(CartItem::class)->findOneBy(['book' => $id, 'user' => $user]);

        if ($cartItem && $cartItem->getQuantity() > 1) {
            // Si l'élément est trouvé et que la quantité est supérieure à 1, on décrémente la quantité
            $cartItem->setQuantity($cartItem->getQuantity() - 1);
            $entityManager->flush();
        }

        // Rediriger vers la page du panier
        return $this->redirectToRoute('app_cart');
    }

    #[Route('/cart/remove/{id}', name: 'app_remove_from_cart')]
    public function removeFromCart(int $id, CartService $cartService): RedirectResponse
    {
        // Utilisez un service ou une logique pour retirer l'article du panier
        $cartService->removeBookFromCart($id);
   
        // Redirigez l'utilisateur vers la page du panier
        return $this->redirectToRoute('app_cart');
    }
}

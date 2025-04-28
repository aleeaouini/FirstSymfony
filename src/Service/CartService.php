<?php

namespace App\Service;

use App\Entity\CartItem;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\SecurityBundle\Security;


class CartService
{
    private $entityManager;
    private $security;

    public function __construct(EntityManagerInterface $entityManager, Security $security)
    {
        $this->entityManager = $entityManager;
        $this->security = $security;
    }

    public function removeBookFromCart(int $bookId)
    {
        $cartItem = $this->entityManager->getRepository(CartItem::class)
            ->findOneBy(['book' => $bookId]);

        if ($cartItem) {
            $this->entityManager->remove($cartItem);
            $this->entityManager->flush();
        }
    }
}

<?php

namespace App\Cart;

use App\Entity\Product;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

class Cart
{
    /**
     * @var CartProduct[]|ArrayCollection
     */
    private $cartProducts;

    public function __construct()
    {
        $this->cartProducts = new ArrayCollection();
    }

    public function addCartProduct(CartProduct $cartProduct): void
    {
        $this->cartProducts[] = $cartProduct;
    }

    public function removeCartProduct(CartProduct $cartProduct)
    {
        $this->cartProducts->remove($cartProduct);
    }

    /**
     * @return CartProduct[]|ArrayCollection
     */
    public function getCartProducts()
    {
        return $this->cartProducts;
    }

    public function getTotalAmount(): int
    {
        $totalAmount = 0;

        foreach ($this->cartProducts as $cartProduct) {
            $totalAmount += $cartProduct->getAmount();
        }

        return $totalAmount;
    }

    public function getCurrency(): string
    {
        return 'EUR';
    }
}

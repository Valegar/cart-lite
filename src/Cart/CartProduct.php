<?php

namespace App\Cart;

use App\Entity\Product;

class CartProduct
{
    /**
     * @var Product
     */
    private $product;

    /**
     * @var int
     */
    private $quantity = 1;

    public function getProduct(): ?Product
    {
        return $this->product;
    }

    public function setProduct(Product $product): void
    {
        $this->product = $product;
    }

    public function getQuantity(): int
    {
        return $this->quantity;
    }

    public function setQuantity(int $quantity): void
    {
        $this->quantity = $quantity;
    }

    public function getName(): string
    {
        return $this->product->getName() ?? '-';
    }

    public function getAmount(): int
    {
        if (!$this->product) {
            return 0;
        }

        return $this->product->getPrice() * $this->quantity;
    }
}

<?php

namespace App\Cart;

use App\Entity\Product;
use App\Repository\ProductRepository;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

class CartManager
{
    /**
     * @var SessionInterface
     */
    private $session;

    /**
     * @var ProductRepository
     */
    private $productRepository;

    public function __construct(
        SessionInterface  $session,
        ProductRepository $productRepository
    )
    {
        $this->session = $session;
        $this->productRepository = $productRepository;
    }

    public function getCart(): Cart
    {
        $cart = new Cart();
        $cartData = $this->getCartData();
        $products = $this->listProductsOfCart();

        foreach ($products as $product) {
            $cartProduct = new CartProduct();
            $cartProduct->setProduct($product);
            $cartProduct->setQuantity($cartData[$product->getId()] ?? 1);
            $cart->addCartProduct($cartProduct);
        }

        return $cart;
    }

    public function editCart(Product $product, int $quantity = 1)
    {
        $cartData = $this->getCartData();
        $currentProductQuantity = $cartData[$product->getId()] ?? 0;
        $newProductQuantity = $currentProductQuantity + $quantity;

        if ($newProductQuantity === 0) {
            unset($cartData[$product->getId()]);
        } else {
            $cartData[$product->getId()] = $newProductQuantity;
        }

        $this->session->set('cart', $cartData);
    }

    public function resetCart()
    {
        $this->session->set('cart', []);
    }

    /**
     * @return Product[]
     */
    private function listProductsOfCart(): array
    {
        $cartData = $this->getCartData();
        $selectedProductsIds = array_keys($cartData);

        return $this->productRepository
            ->findByIds($selectedProductsIds);
    }

    /**
     * The session contain an array of key => value as
     * key = the product id
     * value = the selected quantity
     */
    private function getCartData(): array
    {
        return $this->session->get('cart', []);
    }
}

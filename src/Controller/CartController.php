<?php

namespace App\Controller;

use App\Cart\CartManager;
use App\Entity\Product;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class CartController extends AbstractController
{
    /**
     * @var CartManager
     */
    private $cartManager;

    public function __construct(
        CartManager $cartManager
    )
    {
        $this->cartManager = $cartManager;
    }

    /**
     * @Route("/cart", name="cart_show")
     */
    public function show()
    {
        $cart = $this->cartManager->getCart();

        return $this->render('cart.html.twig', [
            'cart' => $cart,
        ]);
    }

    /**
     * @Route("/cart/{id}/{quantity}/edit",
     *     requirements={"id"="\d+", "quantity"="\d+"},
     *     name="cart_edit"
     * )
     */
    public function edit(Product $product, $quantity)
    {
        $this->cartManager->editCart($product, $quantity);

        return $this->redirectToRoute('cart_show');
    }
}
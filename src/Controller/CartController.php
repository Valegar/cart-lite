<?php

namespace App\Controller;

use App\Cart\CartManager;
use App\Entity\Product;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Translation\TranslatorInterface;

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
     * @Route("/cart",
     *     options = { "expose" = true },
     *     name="cart_show"
     * )
     * @Method("GET")
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
     *     requirements={"id"="\d+", "quantity"="-?\d+"},
     *     options = { "expose" = true },
     *     name="cart_edit"
     * )
     * @Method("GET")
     */
    public function edit(Request $request, Product $product, $quantity)
    {
        $this->cartManager->editCart($product, $quantity);

        if ($request->isXmlHttpRequest()) {
            return new JsonResponse(['status' => 'OK']);
        }

        return $this->redirectToRoute('cart_show');
    }

    /**
     * @Route("/cart/reset", name="cart_reset")
     * @Method("GET")
     */
    public function reset(TranslatorInterface $translator)
    {
        $this->cartManager->resetCart();
        $this->addFlash('success', $translator->trans('flash.your_cart_is_empty'));

        return $this->redirectToRoute('home');
    }
}

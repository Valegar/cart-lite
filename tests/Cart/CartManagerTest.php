<?php

namespace App\Tests\Cart;

use App\Cart\CartManager;
use App\Entity\Product;
use App\Repository\ProductRepository;
use PHPUnit\Framework\TestCase;
use Prophecy\Argument;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

class CartManagerTest extends TestCase
{
    public function testTotalAmountCalculation()
    {
        // Test fixtures: two products
        $fooProduct = (new Product())
            ->setId(1)
            ->setName('Foo')
            ->setPrice(1000);
        $barProduct = (new Product())
            ->setId(2)
            ->setName('Bar')
            ->setPrice(400);

        // The session is called by the cart to manage the customer order
        $sessionProphecy = $this->prophesize(SessionInterface::class);
        $sessionProphecy
            ->set(Argument::exact('cart'), Argument::type('array'))
            ->shouldBeCalled();
        $sessionProphecy
            ->get(Argument::exact('cart'), Argument::type('array'))
            ->shouldBeCalled()
            ->willReturn([ 1 => 1, 2 => 2 ]);
        $session = $sessionProphecy->reveal();

        // The repository will return related products saved in session
        $productRepositoryProphecy = $this->prophesize(ProductRepository::class);
        $productRepositoryProphecy
            ->findByIds(Argument::type('array'))
            ->shouldBeCalled()
            ->willReturn([$fooProduct, $barProduct]);
        $productRepository = $productRepositoryProphecy->reveal();

        // Add 1 Foo at 10EUR and 2 Bar at 4EUR
        $cartManager = new CartManager($session, $productRepository);
        $cartManager->editCart($fooProduct);
        $cartManager->editCart($barProduct, 2);
        $cart = $cartManager->getCart();

        // 1000 + (400 * 2) = 1800
        $this->assertEquals(1800, $cart->getTotalAmount());
    }
}

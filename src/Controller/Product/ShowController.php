<?php

namespace App\Controller\Product;

use App\Entity\Product;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ShowController extends AbstractController
{
    /**
     * @Route("/{id}/show", name="product_show")
     */
    public function __invoke(
        Product $product
    )
    {
        return $this->render('product/show.html.twig', [
            'product' => $product,
        ]);
    }
}

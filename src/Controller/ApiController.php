<?php

namespace App\Controller;

use App\Repository\ProductRepository;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Serializer\SerializerInterface;

class ApiController extends AbstractController
{
    /**
     * @Route("/api", name="api")
     */
    public function __invoke(
        ProductRepository   $productRepository,
        SerializerInterface $serializer
    )
    {
        $products = $productRepository->findAll();
        $productsAsJson = $serializer->serialize($products, 'json', ['groups' => ['list_products']]);

        return JsonResponse::fromJsonString($productsAsJson);
    }
}

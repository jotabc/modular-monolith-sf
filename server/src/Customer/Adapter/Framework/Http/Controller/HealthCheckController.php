<?php

namespace Customer\Adapter\Framework\Http\Controller;

use OpenApi\Attributes as OA;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[OA\Tag(name: 'Customers')]
class HealthCheckController extends AbstractController
{
    #[Route('/health-check', name: 'customer_health_check', methods: ['GET'], priority: 10)]
    public function __invoke(): Response
    {
        return new JsonResponse([
            'message' => 'Module Customer up and running',
        ]);
    }
}

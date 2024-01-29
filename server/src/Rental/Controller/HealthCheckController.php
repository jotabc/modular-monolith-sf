<?php

namespace Rental\Controller;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use OpenApi\Attributes as OA;

#[OA\Tag('Rental')]
class HealthCheckController
{
    public function __invoke(): Response
    {
        return new JsonResponse([
            'message' => 'Module Rental up and running',
        ]);
    }
}

<?php

namespace Rent\Controller;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Nelmio\ApiDocBundle\Annotation as Nelmio;
use OpenApi\Attributes as OA;

#[Nelmio\Areas(['rent'])]
#[OA\Tag('Rent')]
class HealthCheckController
{
    public function __invoke(): Response
    {
        return new JsonResponse([
            'message' => 'Module Rent up and running',
        ]);
    }
}

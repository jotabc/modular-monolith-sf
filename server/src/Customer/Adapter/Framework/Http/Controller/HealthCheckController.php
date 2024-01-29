<?php

namespace Customer\Adapter\Framework\Http\Controller;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Nelmio\ApiDocBundle\Annotation as Nelmio;
use OpenApi\Attributes as OA;

#[Nelmio\Areas(['customer'])]
#[OA\Tag('Customer')]
class HealthCheckController
{
    public function __invoke(): Response
    {
        return new JsonResponse([
            'message' => 'Module Customer up and running',
        ]);
    }
}

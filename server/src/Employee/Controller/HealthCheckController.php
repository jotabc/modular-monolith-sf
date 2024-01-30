<?php

namespace Employee\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Nelmio\ApiDocBundle\Annotation as Nelmio;
use OpenApi\Attributes as OA;

#[Nelmio\Areas(['employee'])]
#[OA\Tag('Employee')]

class HealthCheckController extends AbstractController
{
    public function __invoke(): Response
    {
        return new JsonResponse([
            'message' => 'Module Employee up and running',
        ]);
    }
}

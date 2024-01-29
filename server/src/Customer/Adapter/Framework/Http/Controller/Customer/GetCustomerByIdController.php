<?php

namespace Customer\Adapter\Framework\Http\Controller\Customer;

use Customer\Adapter\Framework\Http\DTO\GetCustomerByIdRequestDTO;
use Customer\Application\UseCase\Customer\GetCustomerById\DTO\GetCustomerByIdInputDTO;
use Customer\Application\UseCase\Customer\GetCustomerById\GetCustomerById;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Nelmio\ApiDocBundle\Annotation as Nelmio;
use OpenApi\Attributes as OA;

#[Nelmio\Areas(['customer'])]
#[OA\Tag('Customer')]
class GetCustomerByIdController
{
    public function __construct(private readonly GetCustomerById $useCase)
    {
    }

    public function __invoke(GetCustomerByIdRequestDTO $request): Response
    {
        $responseDTO = $this->useCase->handle(GetCustomerByIdInputDTO::create($request->id));

        return new JsonResponse($responseDTO);
    }
}

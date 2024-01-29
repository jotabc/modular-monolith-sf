<?php

namespace Customer\Adapter\Framework\Http\Controller\Customer;

use Customer\Adapter\Framework\Http\DTO\GetCustomerByIdRequestDTO;
use Customer\Application\UseCase\Customer\GetCustomerById\DTO\GetCustomerByIdInputDTO;
use Customer\Application\UseCase\Customer\GetCustomerById\GetCustomerById;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use OpenApi\Attributes as OA;
use Symfony\Component\Routing\Annotation\Route;

#[OA\Tag(name: 'Customers')]
class GetCustomerByIdController
{
    public function __construct(private readonly GetCustomerById $useCase)
    {
    }

    #[Route('/{id}', name: 'get_customer_by_id', methods: ['GET'])]
    public function __invoke(GetCustomerByIdRequestDTO $request): Response
    {
        $responseDTO = $this->useCase->handle(GetCustomerByIdInputDTO::create($request->id));

        return new JsonResponse($responseDTO);
    }
}

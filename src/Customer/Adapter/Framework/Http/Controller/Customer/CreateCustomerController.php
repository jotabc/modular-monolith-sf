<?php

namespace Customer\Adapter\Framework\Http\Controller\Customer;

use Customer\Adapter\Framework\Http\DTO\CreateCustomerRequestDTO;
use Customer\Application\UseCase\Customer\CreateCustomer\CreateCustomer;
use Customer\Application\UseCase\Customer\CreateCustomer\DTO\CreateCustomerInputDTO;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class CreateCustomerController
{
    // inyectamos el caso de uso de application, que infraestructura conozca de
    // application no pasa nada, porque infrastruture esta por fuera se comunica
    // con application y application con domain las tres capas
    public function __construct(private readonly CreateCustomer $createCustomer)
    {
    }

    public function __invoke(CreateCustomerRequestDTO $request): Response
    {
        $responseDto = $this->createCustomer->handle(CreateCustomerInputDTO::create($request->name, $request->address, $request->age, $request->employeeId));

        return new JsonResponse(
            ['customerId' => $responseDto->id],
            Response::HTTP_CREATED
        );
    }
}

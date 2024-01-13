<?php

namespace Customer\Infrastructure\Controller\Customer;

use Customer\Application\CreateCustomer\CreateCustomer;
use Customer\Application\CreateCustomer\DTO\CreateCustomerInputDTO;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class CreateCustomerController
{

    # inyectamos el caso de uso de application, que infraestructura conozca de
    # application no pasa nada, porque infrastruture esta por fuera se comunica
    # con application y application con domain las tres capas
    public function __construct(private readonly CreateCustomer $createCustomer)
    {
    }

    public function __invoke(Request $request): Response
    {
        $data = \json_decode($request->getContent(), true);

        $responseDto = $this->createCustomer->__invoke(CreateCustomerInputDTO::create($data['name'], $data['address'], $data['age'], $data['employeeId']));

        return new JsonResponse(
            ['customerId' => $responseDto->id],
            Response::HTTP_CREATED
        );
    }
}

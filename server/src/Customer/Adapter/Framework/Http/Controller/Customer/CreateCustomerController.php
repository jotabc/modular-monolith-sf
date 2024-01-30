<?php

namespace Customer\Adapter\Framework\Http\Controller\Customer;

use Customer\Adapter\Framework\Http\DTO\CreateCustomerRequestDTO;
use Customer\Application\UseCase\Customer\CreateCustomer\CreateCustomer;
use Customer\Application\UseCase\Customer\CreateCustomer\DTO\CreateCustomerInputDTO;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use OpenApi\Attributes as OA;
use Symfony\Component\Routing\Annotation\Route;

#[OA\Tag(name: 'Customers')]
class CreateCustomerController extends AbstractController
{
    // inyectamos el caso de uso de application, que infraestructura conozca de
    // application no pasa nada, porque infrastruture esta por fuera se comunica
    // con application y application con domain las tres capas
    public function __construct(private readonly CreateCustomer $createCustomer)
    {
    }

    #[Route('', name: 'create_customer', methods: ['POST'])]
    public function __invoke(CreateCustomerRequestDTO $request): Response
    {
        $responseDto = $this->createCustomer->handle(CreateCustomerInputDTO::create($request->name, $request->address, $request->age, $request->employeeId));

        return new JsonResponse(
            ['customerId' => $responseDto->id],
            Response::HTTP_CREATED
        );
    }
}

<?php

namespace Customer\Adapter\Framework\Http\Controller\Customer;

use Customer\Adapter\Framework\Http\DTO\CreateCustomerRequestDTO;
use Customer\Application\UseCase\Customer\CreateCustomer\CreateCustomer;
use Customer\Application\UseCase\Customer\CreateCustomer\DTO\CreateCustomerInputDTO;
use Customer\Domain\Exception\CustomerAlreadyExistsException;
use OpenApi\Attributes as OA;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
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
        try {
            $responseDTO = $this->createCustomer->handle(CreateCustomerInputDTO::create($request->name, $request->email, $request->address, $request->age, $request->employeeId));
        } catch (CustomerAlreadyExistsException $e) {
            return $this->json(['error' => $e->getMessage()], Response::HTTP_CONFLICT);
        }

        return $this->json(['customerId' => $responseDTO->id], Response::HTTP_CREATED);
    }
}

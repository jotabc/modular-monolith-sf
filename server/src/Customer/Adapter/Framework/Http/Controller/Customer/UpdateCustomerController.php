<?php

declare(strict_types=1);

namespace Customer\Adapter\Framework\Http\Controller\Customer;

use Customer\Adapter\Framework\Http\DTO\UpdateCustomerRequestDTO;
use Customer\Application\UseCase\Customer\UpdateCustomer\DTO\UpdateCustomerInputDTO;
use Customer\Application\UseCase\Customer\UpdateCustomer\UpdateCustomer;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Nelmio\ApiDocBundle\Annotation as Nelmio;
use OpenApi\Attributes as OA;

#[Nelmio\Areas(['customer'])]
#[OA\Tag('Customer')]
class UpdateCustomerController extends AbstractController
{
    public function __construct(private readonly UpdateCustomer $useCase)
    {
    }

    #[Route('/{id}', name: 'update_customer', methods: ['PATCH'])]
    public function __invoke(UpdateCustomerRequestDTO $request): Response
    {
        $inputDTO = UpdateCustomerInputDTO::create(
            $request->id,
            $request->name,
            $request->address,
            $request->age,
            $request->keys
        );

        $responseDTO = $this->useCase->handle($inputDTO);

        return $this->json($responseDTO->customerData);
    }
}

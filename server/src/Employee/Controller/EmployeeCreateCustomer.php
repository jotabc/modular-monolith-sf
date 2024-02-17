<?php

namespace Employee\Controller;

use Employee\Service\EmployeeCreateCustomerService;
use Employee\Service\Security\Voter\EmployeeVoter;
use GuzzleHttp\Exception\ClientException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class EmployeeCreateCustomer extends AbstractController
{
    public function __construct(
        private readonly EmployeeCreateCustomerService $service,
    ) {
    }

    #[Route('/{id}/customers', name: 'create_employee_customers', methods: ['POST'])]
    public function __invoke(Request $request): Response
    {
        $employeeId = $request->attributes->get('id');
        $this->denyAccessUnlessGranted(EmployeeVoter::CREATE_EMPLOYEE, $employeeId);

        $payload = \json_decode($request->getContent(), true);

        $name = $payload['name'];
        $email = $payload['email'];
        $age = (int) $payload['age'];
        $address = $payload['address'];

        try {
            $customerId = $this->service->create($name, $email, $age, $address, $employeeId);

            return $this->json(['customerId' => $customerId], Response::HTTP_CREATED);
        } catch (\Exception $e) {
            if ($e instanceof ClientException && 409 === $e->getResponse()->getStatusCode()) {
                return $this->json(['error' => $e->getMessage()], Response::HTTP_CONFLICT);
            }

            return $this->json(['error' => 'Internal server error'], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}

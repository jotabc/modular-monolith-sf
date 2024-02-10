<?php

namespace Employee\Controller;

use Employee\Service\GetEmployeeCustomers;
use Employee\Service\Security\Voter\EmployeeVoter;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class GetCustomersController extends AbstractController
{
    public function __construct(
        private readonly GetEmployeeCustomers $service
    ) {
    }

    #[Route('/{id}/customers', name: 'get_employee_customers', methods: ['GET'])]
    public function __invoke(Request $request): Response
    {
        $employeeId = $request->attributes->get('id');
        $page = $request->query->getInt('page');
        $limit = $request->query->getInt('limit');

        // use the voter
        $this->denyAccessUnlessGranted(EmployeeVoter::GET_EMPLOYEE_CUSTOMERS, $employeeId);

        $customers = $this->service->execute($employeeId, $page, $limit);

        return $this->json($customers);
    }
}

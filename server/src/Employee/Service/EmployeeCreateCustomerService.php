<?php

namespace Employee\Service;

use Employee\Http\HttpClientInterface;

class EmployeeCreateCustomerService
{
    private const CREATE_CUSTOMER = '/api/customers';

    public function __construct(
        private readonly HttpClientInterface $httpClient,
    ) {
    }

    public function create(string $name, string $email, int $age, string $address, string $employeeId): string
    {
        $payload = [
            'name' => $name,
            'email' => $email,
            'age' => $age,
            '$address' => $address,
            '$employeeId' => $employeeId,
        ];

        $response = $this->httpClient->post(
            self::CREATE_CUSTOMER,
            ['json' => $payload]
        );

        $responseData = \json_decode($response->getBody()->getContents(), true, 512, \JSON_THROW_ON_ERROR);

        return $responseData['customerId'];
    }
}

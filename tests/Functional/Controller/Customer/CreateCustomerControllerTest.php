<?php

namespace App\Tests\Functional\Controller\Customer;

use App\Tests\Functional\Controller\CustomerControllerTestBase;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class CreateCustomerControllerTest extends CustomerControllerTestBase
{
    private const ENDPOINT = 'customer/create';

    public function testCreateCustomerAndCheckIt(): void
    {
        $payload = [
            'name' => 'Juan',
            'address' => 'Street fake 000',
            'age' => 45,
            'employeeId' => '0466c319-8b65-4f04-b4e2-b964cb174de6'
        ];

        $this->client->request(
            Request::METHOD_POST,
            self::ENDPOINT,
            [],
            [],
            [],
            \json_encode($payload)
        );

        $response = $this->client->getResponse();
        $responseData = $this->getResponseData($response);

        self::assertEquals(Response::HTTP_CREATED, $response->getStatusCode());
        self::assertArrayHasKey('customerId', $responseData);
        self::assertEquals(36, \strlen($responseData['customerId']));

        // TDD

        $this->client->request(
            Request::METHOD_GET,
            \sprintf('/customer/%s', $responseData['customerId'])
        );

        $response = $this->client->getResponse();
        $responseData = $this->getResponseData($response);

        self::assertArrayHasKey('name', $responseData);
        self::assertArrayHasKey('address', $responseData);
        self::assertArrayHasKey('age', $responseData);
        self::assertArrayHasKey('employeeId', $responseData);

        self::assertEquals('Juan', $responseData['name']);
        self::assertEquals('Street fake 000', $responseData['address']);
        self::assertEquals(45, $responseData['age']);
        self::assertEquals(36, \strlen($responseData['employeeId']));

    }


}

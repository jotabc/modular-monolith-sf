<?php

namespace App\Tests\Functional\Customer\Controller\Customer;

use App\Tests\Functional\Customer\Controller\CustomerControllerTestBase;
use Customer\Domain\Exception\ResourceNotFoundException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class UpdateCustomerControllerTest extends CustomerControllerTestBase
{
    private const ENDPOINT = '/customer/%s';
    private const NON_EXISTING_CUSTOMER_ID = 'a695f3f4-8e57-4c8c-ab66-005a5939d4e6';

    /**
     * @dataProvider updateCustomerDataProvider
     */
    public function testUpdateCustomer(array $payload): void
    {
        // create a customer
        $customerId = $this->createCustomer();

        // update a customer
        self::$client->request(
          Request::METHOD_PATCH,
          sprintf(self::ENDPOINT, $customerId),
            [],
            [],
            [],
            json_encode($payload)
        );

        // checks
        $response = self::$client->getResponse();
        $responseData = $this->getResponseData($response);

        self::assertEquals(Response::HTTP_OK, $response->getStatusCode());
        $keys = \array_keys($payload);

        foreach ($keys as $key) {
            self::assertEquals($payload[$key], $responseData[$key]);
        }

    }

    public function testUpdateCustomerWithWrongValue(): void
    {
        $payload = ['name' => 'A'];

        $customerId = $this->createCustomer();

        self::$client->request(
            Request::METHOD_PATCH,
            \sprintf(self::ENDPOINT, $customerId),
            [],
            [],
            [],
            json_encode($payload)
        );

        $response = self::$client->getResponse();

        self::assertEquals(Response::HTTP_BAD_REQUEST, $response->getStatusCode());
    }

    public function testUpdateNonExistingCustomer(): void
    {
        $payload = ['name' => 'Isdra'];

        self::$client->request(
            Request::METHOD_PATCH,
            sprintf(self::ENDPOINT, self::NON_EXISTING_CUSTOMER_ID),
            [],
            [],
            [],
            json_encode($payload)
        );

        $response = self::$client->getResponse();
        $responseData = $this->getResponseData($response);

        self::assertEquals(Response::HTTP_NOT_FOUND, $response->getStatusCode());
        self::assertEquals(ResourceNotFoundException::class, $responseData['class']);
    }


    public static function updateCustomerDataProvider(): iterable
    {
        /* DATA PROVIDER.- Los data provider es una funcionalidad de php unit
          que nos permite crear un set de datos al que se lo podemos pasar a un
          test para que con un solo test podamos probar diff casos de uso así
           evitamos repetir la misma lógica en varios sitios.
       */
        /* yield 'Update name payload' => [
            [
                'name' => 'Brian'
            ]
        ];*/

        yield 'Update address payload' => [
            [
                'address' => 'New Address 111'
            ]
        ];

        yield 'Update name and address payload' => [
            [
                'name' => 'Peter',
                'address' => 'New Address 222'
            ]
        ];

        yield 'Update age payload' => [
            [
                'age' => 33
            ]
        ];
    }

}

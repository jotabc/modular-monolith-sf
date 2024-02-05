<?php

declare(strict_types=1);

namespace App\Tests\Functional\Customer\Controller;

use Employee\Entity\Employee;
use Employee\Repository\EmployeeRepository;
use Employee\Service\Security\PasswordHasherInterface;
use Lexik\Bundle\JWTAuthenticationBundle\Services\JWTTokenManagerInterface;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\BrowserKit\AbstractBrowser;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Uid\Uuid;

class CustomerControllerTestBase extends WebTestCase
{
    protected const CREATE_CUSTOMER_ENDPOINT = '/api/customers';
    protected const NON_EXISTING_CUSTOMER_ID = 'a695f3f4-8e57-4c8c-ab66-005a5939d4e6';

    protected static ?AbstractBrowser $admin = null;

    public function setUp(): void
    {
        if (null === self::$admin) {
            self::$admin = static::createClient();
        }

        // create employee of test
        $admin = new Employee(Uuid::v4()->toRfc4122(), 'admin', 'admin@api.com');
        $password = static::getContainer()->get(PasswordHasherInterface::class)->hashPasswordForUser($admin, '123456789');
        $admin->setPassword($password);

        static::getContainer()->get(EmployeeRepository::class)->save($admin);

        $jwt = static::getContainer()->get(JWTTokenManagerInterface::class)->create($admin);

        // setup headers
        self::$admin->setServerParameters([
            'CONTENT_TYPE' => 'application/json',
            'HTTP_Authorization' => \sprintf('Bearer %s', $jwt),
        ]);

    }

    ## esta función se ejecuta siempre despúes de cada test, lo que hacemos aquí es cerrar el cliente.
    ## con esto me garantizo que cada cliente sea limpio, así liberamos memoria.
    # public function tearDown(): void
    # {
    #     $this->client = null;
    # }

    protected function getResponseData(Response $response): array
    {
        return (array)\json_decode($response->getContent(), true, 512, \JSON_THROW_ON_ERROR);
    }

    protected function createCustomer(): string
    {
        $payload = [
            'name' => 'Peter',
            'address' => 'Fake street 123',
            'age' => 30,
            'employeeId' => 'd368263a-ab71-4587-960d-cfe9725c373f'
        ];

        self::$admin->request(Request::METHOD_POST, self::CREATE_CUSTOMER_ENDPOINT, [], [], [], \json_encode($payload));

        $response = self::$admin->getResponse();
        $responseData = $this->getResponseData($response);

        return $responseData['customerId'];
    }

}

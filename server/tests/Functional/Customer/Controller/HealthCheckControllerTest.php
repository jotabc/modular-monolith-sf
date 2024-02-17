<?php

namespace App\Tests\Functional\Customer\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class HealthCheckControllerTest extends CustomerControllerTestBase
{

    private const ENDPOINT = '/api/customers/health-check';

    public function testCustomerHealthCheck(): void
    {

        // hacemos la petición endpoint
        self::$admin->request(Request::METHOD_GET, self::ENDPOINT);

        // obtenemos la respuesta es necesario convertirla a un array porque
        // así estamos devolviendo un New JsonResponse como en el controlador
        $response = self::$admin->getResponse();
        $responseData = $this->getResponseData($response);

        self::assertEquals(Response::HTTP_OK, $response->getStatusCode());
        self::assertEquals('Module Customer up and running', $responseData['message']);

    }



}

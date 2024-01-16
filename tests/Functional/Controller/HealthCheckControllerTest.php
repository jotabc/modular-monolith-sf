<?php

namespace App\Tests\Functional\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class HealthCheckControllerTest extends WebTestCase
{

    // podemos lanzar los test con el sig comando también
    // vendor/bin/simple-phpunit -c phpunit.xml.dist --filter testCustomerHealthCheck
    // vendor/bin/simple-phpunit -c phpunit.xml.dist --filter HealthCheckControllerTest o con la clase pero este ejecutará to dos los test
    private const ENDPOINT = 'customer/health-check';

    public function testCustomerHealthCheck(): void
    {
        // creamos un cliente
        $client = static::createClient();
        // le pasamos los parametros, pueden ser cokies, headers, tokens, etc
        $client->setServerParameter('CONTENT-TYPE', 'application/json');

        // hacemos la petición endpoint
        $client->request(Request::METHOD_GET, self::ENDPOINT);

        // obtenemos la respuesta es necesario convertirla a un array porque
        // así estamos devolviendo un New JsonResponse como en el controlador
        $response = $client->getResponse();
        $responseData = \json_decode($response->getContent(), true);

        self::assertEquals(Response::HTTP_OK, $response->getStatusCode());
        self::assertEquals('Module Customer up and running', $responseData['message']);

    }



}

<?php

declare(strict_types=1);

namespace App\Tests\Functional\Customer\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\BrowserKit\AbstractBrowser;
use Symfony\Component\HttpFoundation\Response;

class CustomerControllerTestBase extends WebTestCase
{
    protected static ?AbstractBrowser $client = null;

    public function setUp(): void
    {
        if (null === self::$client) {
            self::$client = static::createClient();
            self::$client->setServerParameter('CONTENT_TYPE', 'application/json');
        }
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
}

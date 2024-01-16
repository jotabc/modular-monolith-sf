<?php

namespace App\Tests\Functional\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\BrowserKit\AbstractBrowser;

class CustomerControllerTestBase extends WebTestCase
{
    protected ?AbstractBrowser $client;

    public function setup(): void
    {
        $this->client = static::createClient();
        $this->client->setServerParameter('CONTENT-TYPE', 'application/json');

    }

    ## esta función se ejecuta siempre despúes de cada test, lo que hacemos aquí es cerrar el cliente.
    ## con esto me garantizo que cada cliente sea limpio, así liberamos memoria.
    public function tearDown(): void
    {
        $this->client = null;
    }

    public function getResponseData($response): array
    {
        return (array) \json_decode($response->getContent(), true);

    }

}

<?php

namespace Employee\Http;

use Psr\Http\Message\ResponseInterface;

final class HttpClient implements HttpClientInterface
{
    private ?\GuzzleHttp\Client $client = null;

    protected function getClient(): \GuzzleHttp\Client
    {
        if ($this->client){
            return $this->client;
        }

        $client = new \GuzzleHttp\Client([
            'base_uri' => 'http://localhost:1000/'
        ]);
        $this->client = $client;

        return $client;
    }

    public function get(string $uri, array $options = []): ResponseInterface
    {
        return $this->getClient()->get($uri, $options);
    }
}

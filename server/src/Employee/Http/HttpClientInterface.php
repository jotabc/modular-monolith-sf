<?php

namespace Employee\Http;

use Psr\Http\Message\ResponseInterface;

interface HttpClientInterface
{
    public function get(string $uri, array $options): ResponseInterface;
}

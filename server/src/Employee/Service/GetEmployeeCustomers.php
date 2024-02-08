<?php

namespace Employee\Service;

use Employee\Http\HttpClientInterface;

class GetEmployeeCustomers
{
    private const SEARCH_CUSTOMERS_ENDPOINT = 'api/customers';

    public function __construct(
        private readonly HttpClientInterface $httpClient,
    ) {
    }

    public function execute(string $employeeId, int $page, int $limit): array
    {
        $response = $this->httpClient->get(
            \sprintf(
                '%s?employeeId=%s&page=%s&limit=%s',
                self::SEARCH_CUSTOMERS_ENDPOINT,
                $employeeId,
                $page,
                $limit,
            )
        );

        return \json_decode($response->getBody()->getContents(), true, 512, \JSON_THROW_ON_ERROR);
    }
}

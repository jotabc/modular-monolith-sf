<?php

namespace App\Tests\Unit\Customer\Application\UseCase\Customer\GetCustomerById\DTO;

use Customer\Application\UseCase\Customer\GetCustomerById\DTO\GetCustomerByIdInputDTO;
use Customer\Domain\Exception\InvalidArgumentException;
use PHPUnit\Framework\TestCase;

class GetCustomerByIdInputDTOTest extends TestCase
{
    private const CUSTOMER_ID = '644234a1-8a41-4d40-9770-f4c9fa56a0a9';

    public function testCreateGetCustomerByIdInputDTO(): void
    {
        $dto = GetCustomerByIdInputDTO::create(self::CUSTOMER_ID);

        self::assertInstanceOf(GetCustomerByIdInputDTO::class, $dto);
        self::assertEquals(self::CUSTOMER_ID, $dto->id);
    }

    public function testCreateGetCustomerByIdInputDTOWithNullValue(): void
    {
        self::expectException(InvalidArgumentException::class);
        self::expectExceptionMessage('Invalid arguments [id]');

        GetCustomerByIdInputDTO::create(null);
    }
}

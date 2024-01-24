<?php

namespace App\Tests\Unit\Customer\Application\UseCase\Customer\CreateCustomer\DTO;

use Customer\Application\UseCase\Customer\CreateCustomer\DTO\CreateCustomerInputDTO;
use Customer\Domain\Exception\InvalidArgumentException;
use PHPUnit\Framework\TestCase;

class CreateCustomerInputDTOTest extends TestCase
{
    private const VALUES = [
        'name' => 'Peter',
        'address' => 'Kake street 123',
        'age' => 30,
        'employeeId' => '76529a61-aafc-4066-8402-15eca6b176d6',
    ];

    public function testCreate(): void
    {
        $dto = CreateCustomerInputDTO::create(
            self::VALUES['name'],
            self::VALUES['address'],
            self::VALUES['age'],
            self::VALUES['employeeId']
        );

        self::assertInstanceOf(CreateCustomerInputDTO::class, $dto);

        self::assertEquals(self::VALUES['name'], $dto->name);
        self::assertEquals(self::VALUES['address'], $dto->address);
        self::assertEquals(self::VALUES['age'], $dto->age);
        self::assertEquals(self::VALUES['employeeId'], $dto->employeeId);
    }

    public function testCreateWithNullValues(): void
    {
        self::expectException(InvalidArgumentException::class);
        // self::expectExceptionMessage('Invalid arguments [name, age]');

        CreateCustomerInputDTO::create(
            null,
            self::VALUES['address'],
            null,
            self::VALUES['employeeId']
        );
    }

    public function testNameLengthIsLessThan2(): void
    {
        self::expectException(InvalidArgumentException::class);
        self::expectExceptionMessage('Value must be min [2] and max [10] characters');

        $dto = CreateCustomerInputDTO::create(
            'A',
            self::VALUES['address'],
            self::VALUES['age'],
            self::VALUES['employeeId']
        );
    }

    public function testNameLengthIsGreaterThan10(): void
    {
        self::expectException(InvalidArgumentException::class);
        self::expectExceptionMessage('Value must be min [2] and max [10] characters');

        $dto = CreateCustomerInputDTO::create(
            'ABCDEABCDEAABCDEABCDEA',
            self::VALUES['address'],
            self::VALUES['age'],
            self::VALUES['employeeId']
        );
    }

    public function testAgeHasToBeAtLeast18(): void
    {
        self::expectException(InvalidArgumentException::class);
        self::expectExceptionMessage('Age has to be at least 18');

        $dto = CreateCustomerInputDTO::create(
            self::VALUES['name'],
            self::VALUES['address'],
            17,
            self::VALUES['employeeId']
        );
    }
}

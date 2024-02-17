<?php

namespace App\Tests\Unit\Customer\Application\UseCase\Customer\UpdateCustomer\DTO;

use Customer\Application\UseCase\Customer\UpdateCustomer\DTO\UpdateCustomerInputDTO;
use Customer\Domain\Exception\InvalidArgumentException;
use PHPUnit\Framework\TestCase;

class UpdateCustomerInputDTOTest extends TestCase
{
    private const DATA = [
        'id' => '5fc0e495-c74b-40a7-815d-0d7807b59041',
        'name' => 'Peter',
        'email' => 'peter@api.com',
        'address' => 'Fake street 123',
        'age' => 30,
        'keys' => []
    ];

    public function testCreateDTO(): void
    {
        $dto = UpdateCustomerInputDTO::create(
            self::DATA['id'],
            self::DATA['name'],
            self::DATA['email'],
            self::DATA['address'],
            self::DATA['age'],
            self::DATA['keys']
        );

        self::assertInstanceOf(UpdateCustomerInputDTO::class, $dto);
    }

    public function testCreateWithNullId(): void
    {
        self::expectException(InvalidArgumentException::class);

        UpdateCustomerInputDTO::create(
            null,
            self::DATA['name'],
            self::DATA['email'],
            self::DATA['address'],
            self::DATA['age'],
            self::DATA['keys']
        );
    }

    public function testCreateWithInvalidAge(): void
    {
        self::expectException(InvalidArgumentException::class);

        UpdateCustomerInputDTO::create(
            self::DATA['id'],
            self::DATA['name'],
            self::DATA['email'],
            self::DATA['address'],
            10,
            self::DATA['keys']
        );
    }
}

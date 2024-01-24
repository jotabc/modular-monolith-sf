<?php

namespace App\Tests\Unit\Customer\Application\UseCase\Customer\GetCustomerById\DTO;

use Customer\Application\UseCase\Customer\UpdateCustomer\DTO\UpdateCustomerInputDTO;
use PHPUnit\Framework\TestCase;

class UpdateCustomerInputDTOTest extends TestCase
{

    private const DATA = [
        'id' => '5fc0e495-c74b-40a7-815d-0d7807b59041',
        'name' => 'Peter',
        'address' => 'Fake street 123',
        'age' => 30,
        'keys' => []
    ];

    public function testCreate(): void
    {
        $inputDto = UpdateCustomerInputDTO::create(
            self::DATA['id'],
            self::DATA['name'],
            self::DATA['address'],
            self::DATA['age'],
            self::DATA['keys']
        );

        $this->assertInstanceOf(UpdateCustomerInputDTO::class, $inputDto);

        $this->assertEquals(self::DATA['id'], $inputDto->id);
        $this->assertEquals(self::DATA['name'], $inputDto->name);
        $this->assertEquals(self::DATA['address'], $inputDto->address);
        $this->assertEquals(self::DATA['age'], $inputDto->age);
    }

    public function testUpdateWithNullId(): void
    {
        self::expectException(\InvalidArgumentException::class);

        UpdateCustomerInputDTO::create(
            null,
            self::DATA['name'],
            self::DATA['address'],
            self::DATA['age'],
            self::DATA['keys']
        );
    }

    public function testUpdateWithInvalidAge(): void
    {
        self::expectException(\InvalidArgumentException::class);

        UpdateCustomerInputDTO::create(
            self::DATA['id'],
            self::DATA['name'],
            self::DATA['address'],
            10,
            self::DATA['keys']
        );
    }
}

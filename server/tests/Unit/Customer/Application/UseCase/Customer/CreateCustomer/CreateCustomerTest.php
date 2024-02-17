<?php

namespace App\Tests\Unit\Customer\Application\UseCase\Customer\CreateCustomer;

use Customer\Application\UseCase\Customer\CreateCustomer\CreateCustomer;
use Customer\Application\UseCase\Customer\CreateCustomer\DTO\CreateCustomerInputDTO;
use Customer\Application\UseCase\Customer\CreateCustomer\DTO\CreateCustomerOutputDTO;
use Customer\Domain\Model\Customer;
use Customer\Domain\Repository\CustomerRepository;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

class CreateCustomerTest extends TestCase
{
    private const VALUES = [
        'name' => 'Peter',
        'email' => 'peter@api.com',
        'address' => 'Kake street 123',
        'age' => 30,
        'employeeId' => '76529a61-aafc-4066-8402-15eca6b176d6',
    ];

    private CustomerRepository|MockObject $customerRepository;
    private CreateCustomer $useCase;

    public function setUp(): void
    {
        // se usa el createMock cuando es una interface
        $this->customerRepository = $this->createMock(CustomerRepository::class);
        $this->useCase = new CreateCustomer($this->customerRepository);

        // se usa el createMock cuando es una clase que implementa un contructor con
        // valores y inicializados y no queremos que nos de error.
        // $this->customerRepository = $this->getMockBuilder(CustomerRepository::class)->disableOriginalConstructor()->getMock();
    }

    public function testCreateCustomer(): void
    {
        $dto = CreateCustomerInputDTO::create(
            self::VALUES['name'],
            self::VALUES['email'],
            self::VALUES['address'],
            self::VALUES['age'],
            self::VALUES['employeeId']
        );

        $this->customerRepository
            ->expects($this->once())
            ->method('save')
            ->with(
                $this->callback(function (Customer $customer): bool {
                    return $customer->name() === self::VALUES['name']
                        && $customer->email() === self::VALUES['email']
                        && $customer->address() === self::VALUES['address']
                        && $customer->age() === self::VALUES['age']
                        && $customer->employeeId() === self::VALUES['employeeId'];
                })
            );

        $responseDTO = $this->useCase->handle($dto);

        self::assertInstanceOf(CreateCustomerOutputDTO::class, $responseDTO);
    }
}

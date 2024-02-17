<?php

namespace App\Tests\Unit\Customer\Application\UseCase\Customer\UpdateCustomer;

use Customer\Application\UseCase\Customer\UpdateCustomer\DTO\UpdateCustomerInputDTO;
use Customer\Application\UseCase\Customer\UpdateCustomer\DTO\UpdateCustomerOutputDTO;
use Customer\Application\UseCase\Customer\UpdateCustomer\UpdateCustomer;
use Customer\Domain\Model\Customer;
use Customer\Domain\Repository\CustomerRepository;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

class UpdateCustomerTest extends TestCase
{
  private const DATA = [
    'id' => '5fc0e495-c74b-40a7-815d-0d7807b59041',
    'name' => 'Brian',
    'email' => 'peter@api.com',
    'address' => 'Test address 123',
    'age' => 20
  ];

  private const DATA_TO_UPDATE = [
    'id' => '5fc0e495-c74b-40a7-815d-0d7807b59041',
    'name' => 'Peter',
    'email' => 'peter@api.com',
    'address' => 'Address 111',
    'age' => 40,
    'keys' => [
        'name',
        'address',
        'age'
    ]
  ];

  private const EMPLOYEE_ID = '5fc0e495-c74b-40a7-815d-0d7807b59123';

  private CustomerRepository|MockObject $customerRepository;

  private UpdateCustomerInputDTO $inputDto;

  private UpdateCustomer $useCase;

  public function setUp(): void
  {
    $this->customerRepository = $this->createMock(CustomerRepository::class);
    $this->useCase = new UpdateCustomer($this->customerRepository);

    $this->inputDTO = UpdateCustomerInputDTO::create(
        self::DATA_TO_UPDATE['id'],
        self::DATA_TO_UPDATE['name'],
        self::DATA_TO_UPDATE['email'],
        self::DATA_TO_UPDATE['address'],
        self::DATA_TO_UPDATE['age'],
        self::DATA_TO_UPDATE['keys']
    );

    $this->useCase = new UpdateCustomer($this->customerRepository);
}

    public function testUpdateCustomer(): void
    {
        $customer = Customer::create(
            self::DATA['id'],
            self::DATA['name'],
            self::DATA['email'],
            self::DATA['address'],
            self::DATA['age'],
            self::EMPLOYEE_ID
        );

        $this->customerRepository
            ->expects($this->once())
            ->method('findOneByIdOrFail')
            ->with($this->inputDTO->id)
            ->willReturn($customer);

        $this->customerRepository
            ->expects($this->once())
            ->method('save')
            ->with(
                $this->callback(function (Customer $customer): bool {
                    return $customer->name() === $this->inputDTO->name
                        && $customer->address() === $this->inputDTO->address
                        && $customer->age() === $this->inputDTO->age;
                })
            );

        $responseDTO = $this->useCase->handle($this->inputDTO);

        self::assertInstanceOf(UpdateCustomerOutputDTO::class, $responseDTO);

        self::assertEquals($this->inputDTO->name, $responseDTO->customerData['name']);
        self::assertEquals($this->inputDTO->address, $responseDTO->customerData['address']);
        self::assertEquals($this->inputDTO->age, $responseDTO->customerData['age']);
    }
}

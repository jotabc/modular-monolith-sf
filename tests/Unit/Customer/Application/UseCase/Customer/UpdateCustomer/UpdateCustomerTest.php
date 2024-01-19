<?php

namespace App\Tests\Unit\Customer\Application\UseCase\Customer\GetCustomerById;

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
    'address' => 'Test address 123',
    'age' => 20
  ];

  private const DATA_TO_UPDATE = [
    'id' => '5fc0e495-c74b-40a7-815d-0d7807b59041',
    'name' => 'Peter',
    'address' => 'Address 111',
    'age' => 40
  ];

  private const EMPLOYEE_ID = '5fc0e495-c74b-40a7-815d-0d7807b59123';

  private CustomerRepository|MockObject $customerRepository;

  private UpdateCustomerInputDTO $inputDto;

  private UpdateCustomer $useCase;

  public function setUp(): void
  {
    $this->customerRepository = $this->createMock(CustomerRepository::class);
    $this->useCase = new UpdateCustomer($this->customerRepository);

    $this->inputDto = UpdateCustomerInputDTO::create(
      self::DATA_TO_UPDATE['id'],
      self::DATA_TO_UPDATE['name'],
      self::DATA_TO_UPDATE['address'],
      self::DATA_TO_UPDATE['age'],
      self::EMPLOYEE_ID
    );
  }

  public function testUpdateCustomer(): void
  {

    $customer = Customer::create(
      self::DATA['id'],
      self::DATA['name'],
      self::DATA['address'],
      self::DATA['age'],
      self::EMPLOYEE_ID
    );

    $this->customerRepository
      ->expects($this->once())
      ->method('findOneByIdOrFail')
      ->with($this->inputDto->id)
      ->willReturn($customer);

    $this->customerRepository
      ->expects($this->once())
      ->method('save')
      ->with(
        $this->callback(function (Customer $customer): bool {
          return $customer->name() === $this->inputDto->name
            && $customer->address() === $this->inputDto->address
            && $customer->age() === $this->inputDto->age;
        })
      );

    $reponseDTO = $this->useCase->handle($this->inputDto);

    self::assertInstanceOf(UpdateCustomerOutputDTO::class, $reponseDTO);
    self::assertEquals($this->inputDto->name, $reponseDTO->customerData['name']);
    self::assertEquals($this->inputDto->address, $reponseDTO->customerData['address']);
    self::assertEquals($this->inputDto->age, $reponseDTO->customerData['age']);
  }
}

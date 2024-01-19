<?php

namespace App\Tests\Unit\Customer\Application\UseCase\Customer\GetCustomerById;

use Customer\Application\UseCase\Customer\GetCustomerById\DTO\GetCustomerByIdInputDTO;
use Customer\Application\UseCase\Customer\GetCustomerById\DTO\GetCustomerByIdOutputDTO;
use Customer\Application\UseCase\Customer\GetCustomerById\GetCustomerById;
use Customer\Domain\Exception\ResourceNotFoundException;
use Customer\Domain\Model\Customer;
use Customer\Domain\Repository\CustomerRepository;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

class GetCustomerByIdTest extends TestCase
{
    private const CUSTOMER_DATA = [
        'id' => '644234a1-8a41-4d40-9770-f4c9fa56a0a9',
        'name' => 'Peter',
        'address' => 'Fake street 123',
        'age' => 30,
        'employeeId' => '644234a1-8a41-4d40-9770-f4c9fa56a111'
    ];

    private CustomerRepository|MockObject $customerRepository;
    private GetCustomerById $useCase;

    public function setUp(): void
    {
        $this->customerRepository = $this->createMock(CustomerRepository::class);
        $this->useCase = new GetCustomerById($this->customerRepository);
    }

    public function testGetCustomerById()
    {
        $inputDto = GetCustomerByIdInputDTO::create(self::CUSTOMER_DATA['id']);

        // $customer = $this->createMock(Customer::class);
        // $customer->method('name')->willReturn('Juan');
        // $customer->method('address')->willReturn('Fake street 1234');

        $customer = Customer::create(
            self::CUSTOMER_DATA['id'],
            self::CUSTOMER_DATA['name'],
            self::CUSTOMER_DATA['address'],
            self::CUSTOMER_DATA['age'],
            self::CUSTOMER_DATA['employeeId']
        );

        $this->customerRepository
            ->expects($this->once())
            ->method('findOneByIdOrFail')
            ->with($inputDto->id)
            ->willReturn($customer);

        $responseDTO = $this->useCase->handle($inputDto);

        self::assertInstanceOf(GetCustomerByIdOutputDTO::class, $responseDTO);
        self::assertEquals(self::CUSTOMER_DATA['id'], $responseDTO->id);
        self::assertEquals(self::CUSTOMER_DATA['name'], $responseDTO->name);
        self::assertEquals(self::CUSTOMER_DATA['address'], $responseDTO->address);
        self::assertEquals(self::CUSTOMER_DATA['age'], $responseDTO->age);
        self::assertEquals(self::CUSTOMER_DATA['employeeId'], $responseDTO->employeeId);
    }

    public function testException(): void
    {
        $inputDto = GetCustomerByIdInputDTO::create(self::CUSTOMER_DATA['id']);

        $this->customerRepository
            ->expects($this->once())
            ->method('findOneByIdOrFail')
            ->with($inputDto->id)
            ->willThrowException(ResourceNotFoundException::createFromClassAndId(Customer::class, $inputDto->id));

        self::expectException(ResourceNotFoundException::class);

        $this->useCase->handle($inputDto);
    }

}

<?php

namespace Customer\Application\UseCase\Customer\CreateCustomer;

use Customer\Application\UseCase\Customer\CreateCustomer\DTO\CreateCustomerInputDTO;
use Customer\Application\UseCase\Customer\CreateCustomer\DTO\CreateCustomerOutputDTO;
use Customer\Domain\Model\Customer;
use Customer\Domain\Repository\CustomerRepository;
use Customer\Domain\ValueObject\Uuid;

// en application se implemento lo de domain interfaces etc.
class CreateCustomer
{
    public function __construct(private CustomerRepository $repository)
    {
    }

    public function handle(CreateCustomerInputDTO $dto): CreateCustomerOutputDTO
    {
        $customer = Customer::create(
            Uuid::random()->value(),
            $dto->name,
            $dto->email,
            $dto->address,
            $dto->age,
            $dto->employeeId
        );

        $this->repository->save($customer);

        return new CreateCustomerOutputDTO($customer->id());
    }
}

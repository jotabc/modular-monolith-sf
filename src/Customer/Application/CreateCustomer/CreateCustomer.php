<?php

namespace Customer\Application\CreateCustomer;

use Customer\Application\CreateCustomer\DTO\CreateCustomerInputDTO;
use Customer\Domain\Model\Customer;
use Customer\Domain\Repository\CustomerRepository;
use Customer\Domain\ValueObject\Uuid;

# en application se implemento lo de domain interfaces etc.
class CreateCustomer
{
    public function __construct(private CustomerRepository $repository)
    { }

    public function __invoke(CreateCustomerInputDTO $dto): void
    {
        $customer = new Customer(Uuid::random()->value(), $dto->name, $dto->address, $dto->age, $dto->employeeId);

        $this->repository->save($customer);

    }

}

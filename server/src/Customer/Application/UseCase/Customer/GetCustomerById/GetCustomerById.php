<?php

namespace Customer\Application\UseCase\Customer\GetCustomerById;

use Customer\Application\UseCase\Customer\GetCustomerById\DTO\GetCustomerByIdInputDTO;
use Customer\Application\UseCase\Customer\GetCustomerById\DTO\GetCustomerByIdOutputDTO;
use Customer\Domain\Repository\CustomerRepository;

class GetCustomerById
{
    public function __construct(
        public readonly CustomerRepository $repo
    ) {
    }

    public function handle(GetCustomerByIdInputDTO $dto): GetCustomerByIdOutputDTO
    {
        $customer = $this->repo->findOneByIdOrFail($dto->id);

        return GetCustomerByIdOutputDTO::create($customer);
    }
}

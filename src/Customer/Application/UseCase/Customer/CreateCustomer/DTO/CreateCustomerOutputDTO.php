<?php

namespace Customer\Application\UseCase\Customer\CreateCustomer\DTO;

class CreateCustomerOutputDTO
{
    public function __construct(public readonly string $id)
    {
    }
}

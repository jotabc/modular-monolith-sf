<?php

namespace Customer\Application\UseCase\Customer\GetCustomerById\DTO;

use Customer\Domain\Exception\InvalidArgumentException;

class GetCustomerByIdInputDTO
{
    public function __construct(
        public readonly ?string $id
    )
    {
    }

    public static function create(?string $id): self
    {
        if (\is_null($id)) {
            throw InvalidArgumentException::createFormArgument('id');
        }

        return new static($id);
    }

}

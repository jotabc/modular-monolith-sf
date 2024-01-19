<?php

namespace Customer\Application\UseCase\Customer\GetCustomerById\DTO;

use Customer\Domain\Validation\Traits\AssertNotNullTrait;

class GetCustomerByIdInputDTO
{
    use AssertNotNullTrait;

    private const ARGS = ['id'];
    public function __construct(
        public readonly ?string $id
    )
    {
        $this->assertNotNull(self::ARGS, [$id]);
    }

    public static function create(?string $id): self
    {
        return new static($id);
    }

}

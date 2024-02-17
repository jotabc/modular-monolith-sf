<?php

namespace Customer\Application\UseCase\Customer\CreateCustomer\DTO;

use Customer\Domain\Model\Customer;
use Customer\Domain\Validation\Traits\AssertLengthRangeTrait;
use Customer\Domain\Validation\Traits\AssertMinimumAgeTrait;
use Customer\Domain\Validation\Traits\AssertNotNullTrait;

class CreateCustomerInputDTO
{
    use AssertNotNullTrait;
    use AssertLengthRangeTrait;
    use AssertMinimumAgeTrait;

    private const ARGS = [
        'age',
        'employeeId',
    ];

    private function __construct(
        public readonly ?string $name,
        public readonly ?string $email,
        public readonly ?string $address,
        public readonly ?int $age,
        public readonly ?string $employeeId
    ) {
        $this->assertNotNull(self::ARGS, [$age, $employeeId]);

        if (!\is_null($name)) {
            $this->asserValueRangeLength($name, Customer::NAME_MIN_LENGTH, Customer::NAME_MAX_LENGTH);
        }

        $this->assertMinimumAge($age, Customer::MINIMUM_AGE);
    }

    public static function create(?string $name, ?string $email, ?string $address, ?int $age, ?string $employeeId): self
    {
        return new static($name, $email, $address, $age, $employeeId);
    }
}

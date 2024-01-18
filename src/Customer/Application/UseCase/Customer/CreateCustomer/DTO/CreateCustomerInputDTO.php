<?php

namespace Customer\Application\UseCase\Customer\CreateCustomer\DTO;

use Customer\Domain\Exception\InvalidArgumentException;

class CreateCustomerInputDTO
{
    public const VALUES = [
        'name',
        'address',
        'age',
        'employeeId'
    ];
    private const MINIMUM_AGE = 18;

    private function __construct(
        public readonly string $name,
        public readonly string $address,
        public readonly int $age,
        public readonly string $employeeId
    )
    { }

    public static function create(?string $name, ?string $address, ?int $age, ?string $employeeId): self
    {
        self::validateFields(\func_get_args());
        static::validateNameLength($name);
        static::checkAge($age);

        return new static($name, $address, $age, $employeeId);
    }

    // esto devuelve un array con los valores que recibe la función en este caso name, address, age y employeeID. [0: 'name', 1: 'Peter', 2: 30, 3: 'string_exmaple'] devuelve el valor.
    private static function validateFields(array $fields): void
    {
        // array_combine combina 2 arrays, el primer array los pone como keys, y el segundo array el valor.
        // ejm $values = ['name' => 'Peter', 'address' => 'string_exmaple', 'age' => 30, 'employeeId' => 'string_exmaple'];
        $values = \array_combine(self::VALUES, $fields);
        $emptyValues = [];

        foreach($values as $key => $value) {
            if (\is_null($value)) {
                $emptyValues[] = $key;
            }
        }

        if (!empty($emptyValues)) {
            throw InvalidArgumentException::createFromArray($emptyValues);
        }

    }

    private static function validateNameLength(string $name): void
    {
        if(\strlen($name) < 2 || \strlen($name) > 10) {
            throw InvalidArgumentException::createFromArgument('name');
        }
    }

    private static function checkAge(int $age): void
    {
        if(self::MINIMUM_AGE > $age) {
            throw InvalidArgumentException::createFromMessage(\sprintf('Age has to be at least %d', self::MINIMUM_AGE));
        }
    }

}

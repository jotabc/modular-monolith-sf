<?php

namespace Customer\Domain\Validation\Traits;

/* un trait en php es como una clase especial que suele tener lógica común para varias clases
   y podemos usarla en otras clases para tener esa funcionalidad, como en php solo se puede
    extender deuna clase los traits son muy útiles cuando tenemos un código que es común para
    varias clases y no podemos extender más de una. Por ejem podemos usarlo en los createdAt
    y updatedAt. y su forma de uso es colocando dentro de la calse donde se usara use AssertNotNullTrait.
*/

use Customer\Domain\Exception\InvalidArgumentException;

trait AssertNotNullTrait
{
    // esto devuelve un array con los valores que recibe la función en este caso name, address, age y employeeID. [0: 'name', 1: 'Peter', 2: 30, 3: 'string_exmaple'] devuelve el valor.
    public function assertNotNull(array $args, array $values): void
    {
        // array_combine combina 2 arrays, el primer array los pone como keys, y el segundo array el valor.
        // ejm $values = ['name' => 'Peter', 'address' => 'string_exmaple', 'age' => 30, 'employeeId' => 'string_exmaple'];
        $values = \array_combine($args, $values);
        $emptyValues = [];

        foreach ($values as $key => $value) {
            if (\is_null($value)) {
                $emptyValues[] = $key;
            }
        }

        if (!empty($emptyValues)) {
            throw InvalidArgumentException::createFromArray($emptyValues);
        }
    }
}

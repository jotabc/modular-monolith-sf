<?php

namespace Employee\Repository;

use Employee\Entity\Employee;

interface EmployeeRepository
{
    public function save(Employee $employee): void;

    public function remove(Employee $employee): void;

    public function findOneByEmailOrFail(string $email): Employee;

    public function findOneByEmail(string $email): ?Employee;
}

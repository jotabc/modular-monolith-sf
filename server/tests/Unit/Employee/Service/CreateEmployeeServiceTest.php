<?php

declare(strict_types=1);

namespace App\Tests\Unit\Employee\Service;

use Customer\Domain\ValueObject\Uuid;
use PHPUnit\Framework\TestCase;
use Employee\Repository\EmployeeRepository;
use Employee\Service\Security\PasswordHasherInterface;
use Employee\Entity\Employee;
use Employee\Service\CreateEmployeeService;
use Employee\Exception\EmployeeAlreadyExistsException;

class CreateEmployeeServiceTest extends TestCase
{
    // verificamos que necesitamos en el constructor de lo que vayamos a testear
    // en este caso un servicio.

    private readonly EmployeeRepository $employeeRepository;
    private readonly PasswordHasherInterface $passwordHasherInterface;
    private readonly CreateEmployeeService $service;

    public function setUp(): void
    {
        $this->employeeRepository = $this->createMock(EmployeeRepository::class);
        $this->passwordHasherInterface = $this->createMock(PasswordHasherInterface::class);
        $this->service = new CreateEmployeeService($this->employeeRepository, $this->passwordHasherInterface);
    }

    public function testCreateEmployee(): void
    {
        $name = 'Peter';
        $email = 'peter@api.com';
        $password = 'Password1!';

        $this->passwordHasherInterface
            ->expects($this->once())
            ->method('hashPasswordForUser')
            ->with(
                $this->callback(
                    function (Employee $employee) use ($name, $email, $password): bool {
                        return $employee->getName() === $name
                            && $employee->getEmail() === $email;
                }),
                $this->callback(
                    function (string $plainPassword) use ($password): bool {
                        return $plainPassword === $password;
                    }
                )
            );

        $this->employeeRepository
            ->expects($this->once())
            ->method('save')
            ->with(
                $this->callback(
                    fn(Employee $employee) => $employee->getName() === $name && $employee->getEmail() === $email
                )
            );

        $output = $this->service->create($name, $email, $password);

        self::arrayHasKey('id', $output);
        self::arrayHasKey('name', $output);
        self::arrayHasKey('id', $output);

        self::assertEquals($name, $output['name']);
        self::assertEquals($email, $output['email']);
    }

    /**
     * CASE_0 Case for repository method with exception
     */
    /*public function testCreateEmployeeWithExistingEmail(): void
    {
        $name = 'Peter';
        $email = 'peter@api.com';
        $password = 'Password1!';

        $this->employeeRepository
            ->expects($this->once())
            ->method('findOneByEmailOrFail')
            ->with($email)
            ->willThrowException(EmployeeAlreadyExistsException::createFromEmail($email));

        self::expectException(EmployeeAlreadyExistsException::class);

        $this->service->create($name, $email, $password);

    }*/

    /**
     * CASE_1 Case for repository method without exception
     */
    public function testCreateEmployeeWithExistingEmail(): void
    {
        $name = 'Peter';
        $email = 'peter@api.com';
        $password = 'Password1!';

        $employee = new Employee(Uuid::random()->value(), $name, $email);

        $this->employeeRepository
            ->expects($this->once())
            ->method('findOneByEmail')
            ->with($email)
            ->willReturn($employee);

        self::expectException(EmployeeAlreadyExistsException::class);

        $this->service->create($name, $email, $password);

    }

}

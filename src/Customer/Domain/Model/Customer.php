<?php

namespace Customer\Domain\Model;

## en esta modelo es donde nosotros debemos de pasarle los tipos de datos primitivos
## es decir el modelo no tiene que tener ninguna importación de librerias de terceros
## el verdadero tipo de dato se deberia de pasar en nuestra entidad que está dentro de
## Customer/Infrastructure/Database/ORM/Doctrine/Entity/DoctrineCustomer.php
class Customer
{
    public function __construct(
        private readonly string $id,
        private string $name,
        private string $address,
        private int $age,
        private readonly string $employeeId
    ) {
    }

    public function id(): string
    {
        return $this->id;
    }

    public function name(): string
    {
        return $this->name;
    }

    public function setName(string $name): void
    {
        $this->name = $name;
    }

    public function address(): string
    {
        return $this->address;
    }

    public function setAddress(string $address): void
    {
        $this->address = $address;
    }

    public function age(): int
    {
        return $this->age;
    }

    public function setAge(int $age): void
    {
        $this->age = $age;
    }

    public function employeeId(): string
    {
        return $this->employeeId;
    }

}
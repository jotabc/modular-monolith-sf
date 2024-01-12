<?php

namespace Employee\Entity;

class Employee
{
    public function __construct(
        private readonly string $id
    ) { }

    public function getId(): string
    {
        return $this->id;
    }

}

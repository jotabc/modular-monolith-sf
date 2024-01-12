<?php

namespace Customer\Entity;

class Customer
{
    private string $moduleAId;

    public function __construct(
        private readonly string $id
    ) { }

    public function getId(): string
    {
        return $this->id;
    }

}

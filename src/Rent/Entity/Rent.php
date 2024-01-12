<?php

namespace Rent\Entity;

class Rent
{
    public function __construct(
        private readonly string $id
    )
    { }

    public function getId(): string
    {
        return $this->id;
    }

}

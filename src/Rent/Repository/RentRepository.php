<?php

namespace Rent\Repository;

use Rent\Entity\Rent;

interface RentRepository
{
    public function save(Rent $rent): void;
}

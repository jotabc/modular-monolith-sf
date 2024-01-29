<?php

namespace Rental\Repository;

use Rental\Entity\Rental;

interface RentRepository
{
    public function save(Rental $rent): void;
}

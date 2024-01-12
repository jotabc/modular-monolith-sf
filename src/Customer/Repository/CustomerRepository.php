<?php

namespace Customer\Repository;

use Customer\Entity\Customer;

interface CustomerRepository
{
    public function save(Customer $customer): void;
}

<?php

namespace Customer\Domain\Validator;

interface ValidatorInterface
{
    public function validate(object $dto): void;
}

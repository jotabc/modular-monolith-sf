<?php

namespace Customer\Domain\Exception;

use \InvalidArgumentException as NativeInvalidArgumentException;

class InvalidArgumentException extends NativeInvalidArgumentException
{
    public static function createFromMessage(string $message): self
    {
        return new static($message);
    }

    public static function createFormArgument(string $argument): self
    {
        return new static(\sprintf('Invalid argument %s', $argument));
    }

    public static function createFormArray(array $arguments): self
    {
        return new static(\sprintf('Invalid arguments %s', implode(', ', $arguments)));

    }

}

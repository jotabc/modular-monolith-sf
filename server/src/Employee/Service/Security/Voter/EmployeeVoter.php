<?php

namespace Employee\Service\Security\Voter;

use Employee\Entity\Employee;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;

class EmployeeVoter extends Voter
{
    public const GET_EMPLOYEE_CUSTOMERS = 'GET_EMPLOYEE_CUSTOMERS';
    public const CREATE_EMPLOYEE = 'CREATE_EMPLOYEE';

    protected function supports(string $attribute, $subject): bool
    {
        return \in_array($attribute, $this->allowedAttributes(), true) && \is_string($subject);
    }

    /** @param string $subject */
    protected function voteOnAttribute(string $attribute, $subject, TokenInterface $token): bool
    {
        /** @var Employee $tokenUser */
        $tokenUser = $token->getUser();

        if (\in_array($attribute, $this->allowedAttributes(), true)) {
            return $tokenUser->getId() === $subject;
        }

        return false;
    }

    public function allowedAttributes(): array
    {
        return [
            self::GET_EMPLOYEE_CUSTOMERS,
            self::CREATE_EMPLOYEE,
        ];
    }
}

<?php

namespace Employee\Service\Security\Listener;

use Employee\Entity\Employee;
use Lexik\Bundle\JWTAuthenticationBundle\Event\JWTCreatedEvent;
use Symfony\Component\HttpFoundation\RequestStack;

final class JWTCreatedListener
{
    public function __construct(
        private readonly RequestStack $requestStack
    ) {
    }

    public function onJWTCreated(JWTCreatedEvent $event): void
    {
        /** @var Employee $user */
        $user = $event->getUser();

        $payload = $event->getData();
        $payload['id'] = $user->getId();
        $payload['name'] = $user->getName();

        $event->setData($payload);
    }
}

<?php

namespace Rental\Repository;

use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\Persistence\ObjectManager;
use Rental\Entity\Rental;

class DoctrineRentRepository implements RentRepository
{
    private readonly ServiceEntityRepository $repository;
    private readonly ObjectManager $manager;

    public function __construct(ManagerRegistry $managerRegistry)
    {
        $this->repository = new ServiceEntityRepository($managerRegistry, Rental::class);
        $this->manager = $managerRegistry->getManager();
    }

    public function save(Rental $rent): void
    {
        $this->manager->persist($rent);
        $this->manager->flush();
    }
}

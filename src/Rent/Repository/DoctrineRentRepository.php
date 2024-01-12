<?php

namespace Rent\Repository;

use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\Persistence\ObjectManager;
use Rent\Entity\Rent;

class DoctrineRentRepository implements RentRepository {

    private readonly ServiceEntityRepository $repository;
    private readonly ObjectManager $manager;

    public function __construct(ManagerRegistry $managerRegistry)
    {
        $this->repository = new ServiceEntityRepository($managerRegistry, Rent::class);
        $this->manager = $managerRegistry->getManager();
    }

    public function save(Rent $rent): void
    {
        $this->manager->persist($rent);
        $this->manager->flush();
    }
}

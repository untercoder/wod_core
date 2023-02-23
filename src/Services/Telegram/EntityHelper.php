<?php

namespace App\Services\Telegram;

use App\Entity\Interface\EntityInterface;
use App\Services\Telegram\Interface\EntityHelperInterface;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

abstract class EntityHelper implements EntityHelperInterface
{

    public function __construct(
        private ServiceEntityRepository $repository,
        private ManagerRegistry $doctrine
    ) {
    }

    public function save(EntityInterface $entity): void
    {
        $entityManager = $this->doctrine->getManager();
        $entityManager->persist($entity);
        $entityManager->flush();
    }


}
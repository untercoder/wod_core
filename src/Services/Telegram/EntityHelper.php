<?php

namespace App\Services\Telegram;

use App\Services\Telegram\Interface\EntityHelperInterface;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

abstract class EntityHelper
{

    public function __construct(
        private ServiceEntityRepository $repository,
        private ManagerRegistry $doctrine
    ) {
    }

    public function save($entity): void
    {
        $entityManager = $this->doctrine->getManager();
        $entityManager->persist($entity);
        $entityManager->flush();
    }


}
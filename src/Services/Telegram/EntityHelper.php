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

    public function empty(int $chatId) : bool {
        return !($this->repository->findOneBy(['chatId' => $chatId]));
    }
    public function save(EntityInterface $entity): void
    {
        $entityManager = $this->doctrine->getManager();
        $entityManager->persist($entity);
        $entityManager->flush();
    }

    public function getAll(array $params): array
    {
        return $this->repository->findBy($params);
    }

    public function getOne(array $params): EntityInterface
    {
        return $this->repository->findOneBy($params);
    }
}
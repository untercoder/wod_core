<?php

namespace App\Services\Telegram\Interface;

use App\Entity\Interface\EntityInterface;
use Telegram\Bot\Objects\Message;

interface EntityHelperInterface
{
    public function empty(int $id): bool;

    public function make(Message $data): EntityInterface;

    public function save(EntityInterface $entity): void;

    public function getOne(array $params): EntityInterface;

    public function getAll(array $params): array;


}
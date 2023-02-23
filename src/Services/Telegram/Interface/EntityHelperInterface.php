<?php

namespace App\Services\Telegram\Interface;

use App\Entity\Interface\EntityInterface;
use Telegram\Bot\Objects\Message;

interface EntityHelperInterface
{
    public function make(Message $data): EntityInterface;

    public function save(EntityInterface $entity): void;
}
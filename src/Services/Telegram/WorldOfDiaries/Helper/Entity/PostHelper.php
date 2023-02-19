<?php

namespace App\Services\Telegram\WorldOfDiaries\Helper\Entity;

use App\Entity\Interface\EntityInterface;
use App\Entity\Post;
use App\Repository\PostRepository;
use App\Services\Telegram\EntityHelper;
use Doctrine\Persistence\ManagerRegistry;
use Telegram\Bot\Objects\Message;

class PostHelper extends EntityHelper
{
    public function __construct(
        private PostRepository $userRepository,
        private ManagerRegistry $doctrine
    ) {
        parent::__construct($this->userRepository, $this->doctrine);
    }


    public function make(Message $data): EntityInterface
    {
        return new Post();
        // TODO: Implement make() method.
    }
}
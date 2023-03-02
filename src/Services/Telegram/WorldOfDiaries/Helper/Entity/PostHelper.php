<?php

namespace App\Services\Telegram\WorldOfDiaries\Helper\Entity;

use App\Entity\Post;
use App\Entity\User;
use App\Repository\PostRepository;
use App\Repository\UserRepository;
use App\Services\Telegram\EntityHelper;
use Doctrine\Persistence\ManagerRegistry;
use Telegram\Bot\Objects\Message;

class PostHelper extends EntityHelper
{
    private const LOW_PRIORITY = 'LOW';
    private const HIGH_PRIORITY = 'HIGH';
    public function __construct(
        private PostRepository $postRepository,
        private ManagerRegistry $doctrine,
        private UserRepository $userRepository,
    ) {
        parent::__construct($this->userRepository, $this->doctrine);
    }

    public function make(Message $data): Post
    {
        $post = new Post();
        $post->setPostId($data->messageId);
        $post->setChatId($data->chat->id);
        $post->setPriority(self::LOW_PRIORITY);
        $post->setPublished(false);
        return $post;
    }

    public function findPost(User $user): Post|false {
        $post = $this->postRepository->findOneBy(['userId' => $user->getId()]);
        if (isset($post)) {
            return $post;
        }
        return false;
    }

    public function createPost(Message $data, User $user): Post {
        $post = $this->make($data);
        $post->setUserId($user->getId());
        $this->save($post);
        return $post;
    }


}
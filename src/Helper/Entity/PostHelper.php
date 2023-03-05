<?php

namespace App\Helper\Entity;

use App\Entity\Post;
use App\Entity\User;
use App\Repository\PostRepository;
use App\Repository\UserRepository;
use App\Services\Telegram\EntityHelper;
use App\Trait\DateTrait;
use Doctrine\Persistence\ManagerRegistry;
use Telegram\Bot\Objects\Message;

class PostHelper extends EntityHelper
{
    use DateTrait;
    private const LOW_PRIORITY = 'LOW';

    private const HIGH_PRIORITY = 'HIGH';

    private const MODERATE_SATE_NOT_SENT = 'not_sent';

    private const MODERATE_STATE_SENT = 'sent';

    private const MODERATE_STATE_APPROVED = 'approved';

    private const MODERATE_STATE_CORRECT = 'correct';


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
        $post->setLastActivity($this->getDateTime($data->date));
        $post->setModerateState(self::MODERATE_SATE_NOT_SENT);
        $this->save($post);
        return $post;
    }

    public function updatePost(Post $post, Message $data): Post {
        $post->setLastActivity($this->getDateTime($data->date));
        $post->setPostId($data->messageId);
        $post->setModerateState(self::MODERATE_SATE_NOT_SENT);
        $this->save($post);
        return $post;
    }

    public function moderation(Post $post): Post {
        $post->setModerateState(self::MODERATE_STATE_SENT);
        $this->save($post);
        return $post;
    }

    public function moderationPassed(Post $post) : Post {
        $post->setModerateState(self::MODERATE_STATE_APPROVED);
        $this->save($post);
        return $post;
    }

    public function moderationFailed(Post $post) : Post {
        $post->setModerateState(self::MODERATE_STATE_CORRECT);
        $this->save($post);
        return $post;
    }


}
<?php

namespace App\Entity;

use App\Repository\PostRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PostRepository::class)]
class Post implements \JsonSerializable
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(unique: true)]
    private ?int $userId = null;

    #[ORM\Column]
    private ?int $postId = null;

    #[ORM\Column(unique: true)]
    private ?int $chatId = null;

    #[ORM\Column(length: 255)]
    private ?string $priority = null;

    #[ORM\Column]
    private ?bool $published = null;

    #[ORM\Column]
    private ?string $moderateState = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $lastActivity  = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUserId(): ?int
    {
        return $this->userId;
    }

    public function getModerateState(): ?string
    {
        return $this->moderateState;
    }

    public function setModerateState(?string $moderateState): void
    {
        $this->moderateState = $moderateState;
    }

    public function getLastActivity(): ?\DateTimeInterface
    {
        return $this->lastActivity;
    }


    public function setLastActivity(?\DateTimeInterface $lastActivity): void
    {
        $this->lastActivity = $lastActivity;
    }



    public function setUserId(int $user_id): self
    {
        $this->userId = $user_id;

        return $this;
    }

    public function getPriority(): ?string
    {
        return $this->priority;
    }

    public function setPriority(string $priority): self
    {
        $this->priority = $priority;

        return $this;
    }

    public function getPublished(): ?bool
    {
        return $this->published;
    }

    public function setPublished(?bool $published): void
    {
        $this->published = $published;
    }

    public function getPostId(): ?int
    {
        return $this->postId;
    }

    public function setPostId(?int $postId): void
    {
        $this->postId = $postId;
    }


    public function getChatId(): ?int
    {
        return $this->chatId;
    }

    public function setChatId(?int $chatId): void
    {
        $this->chatId = $chatId;
    }

    public function jsonSerialize(): mixed
    {
        return get_object_vars($this);
    }
}

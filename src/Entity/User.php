<?php

namespace App\Entity;

use App\Entity\Interface\EntityInterface;
use App\Repository\UserRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: UserRepository::class)]
#[ORM\Table(name: '`user`')]
class User implements EntityInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(unique: true)]
    private ?int $id = null;

    #[ORM\Column(unique: true)]
    private ?int $chatId = null;

    #[ORM\Column(length: 255, unique: true)]
    private ?string $username = null;

    #[ORM\Column(length: 255)]
    private ?string $language_code = null;

    #[ORM\Column(nullable: true, unique: true)]
    private ?int $post_id = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $last_activity = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getChatId(): ?int
    {
        return $this->chatId;
    }

    public function setChatId(int $chatId): self
    {
        $this->chatId = $chatId;

        return $this;
    }

    public function getUsername(): ?string
    {
        return $this->username;
    }

    public function setUsername(string $username): self
    {
        $this->username = $username;

        return $this;
    }

    public function getLanguageCode(): ?string
    {
        return $this->language_code;
    }

    public function setLanguageCode(string $language_code): self
    {
        $this->language_code = $language_code;

        return $this;
    }

    public function getPostId(): ?int
    {
        return $this->post_id;
    }

    public function setPostId(?int $post_id): self
    {
        $this->post_id = $post_id;

        return $this;
    }

    public function getlastActivity(): ?\DateTimeInterface
    {
        return $this->last_activity;
    }

    public function setlastActivity(\DateTimeInterface $last_activity): self
    {
        $this->last_activity = $last_activity;

        return $this;
    }

    public function jsonSerialize(): mixed
    {
        return get_object_vars($this);
    }
}

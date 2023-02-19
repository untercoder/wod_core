<?php

namespace App\Entity;

use App\Entity\Interface\EntityInterface;
use App\Repository\PostRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PostRepository::class)]
class Post implements EntityInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(unique: true)]
    private ?int $id = null;

    #[ORM\Column(unique: true)]
    private ?int $user_id = null;

    #[ORM\Column]
    private array $body = [];

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $last_update = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUserId(): ?int
    {
        return $this->user_id;
    }

    public function setUserId(int $user_id): self
    {
        $this->user_id = $user_id;

        return $this;
    }

    public function getBody(): array
    {
        return $this->body;
    }

    public function setBody(array $body): self
    {
        $this->body = $body;

        return $this;
    }

    public function getLastUpdate(): ?\DateTimeInterface
    {
        return $this->last_update;
    }

    public function setLastUpdate(\DateTimeInterface $last_update): self
    {
        $this->last_update = $last_update;

        return $this;
    }

    public function jsonSerialize(): mixed
    {
        return get_object_vars($this);
    }
}

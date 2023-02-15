<?php

namespace App\Entity;

use App\Repository\MessagesRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: MessagesRepository::class)]
class Messages
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'messages')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Likes $likes = null;

    #[ORM\ManyToOne(inversedBy: 'messages')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Users $userSender = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $content = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $dateSend = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLikes(): ?Likes
    {
        return $this->likes;
    }

    public function setLikes(?Likes $likes): self
    {
        $this->likes = $likes;

        return $this;
    }

    public function getUserSender(): ?Users
    {
        return $this->userSender;
    }

    public function setUserSender(?Users $userSender): self
    {
        $this->userSender = $userSender;

        return $this;
    }

    public function getContent(): ?string
    {
        return $this->content;
    }

    public function setContent(string $content): self
    {
        $this->content = $content;

        return $this;
    }

    public function getDateSend(): ?\DateTimeInterface
    {
        return $this->dateSend;
    }

    public function setDateSend(\DateTimeInterface $dateSend): self
    {
        $this->dateSend = $dateSend;

        return $this;
    }
}

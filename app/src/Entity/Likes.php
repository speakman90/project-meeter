<?php

namespace App\Entity;

use App\Repository\LikesRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: LikesRepository::class)]
class Likes
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::DATE_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $dateMatch = null;

    #[ORM\Column]
    private ?bool $trash = null;

    #[ORM\OneToMany(mappedBy: 'likes', targetEntity: Messages::class)]
    private Collection $messages;

    #[ORM\ManyToOne(inversedBy: 'user1')]
    private ?Users $user1 = null;

    #[ORM\ManyToOne(inversedBy: 'user2')]
    private ?Users $user2 = null;

    public function __construct()
    {
        $this->messages = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDateMatch(): ?\DateTimeInterface
    {
        return $this->dateMatch;
    }

    public function setDateMatch(?\DateTimeInterface $dateMatch): self
    {
        $this->dateMatch = $dateMatch;

        return $this;
    }

    public function isTrash(): ?bool
    {
        return $this->trash;
    }

    public function setTrash(bool $trash): self
    {
        $this->trash = $trash;

        return $this;
    }

    /**
     * @return Collection<int, Messages>
     */
    public function getMessages(): Collection
    {
        return $this->messages;
    }

    public function addMessage(Messages $message): self
    {
        if (!$this->messages->contains($message)) {
            $this->messages->add($message);
            $message->setLikes($this);
        }

        return $this;
    }

    public function removeMessage(Messages $message): self
    {
        if ($this->messages->removeElement($message)) {
            // set the owning side to null (unless already changed)
            if ($message->getLikes() === $this) {
                $message->setLikes(null);
            }
        }

        return $this;
    }

    public function getUser1(): ?Users
    {
        return $this->user1;
    }

    public function setUser1(?Users $user1): self
    {
        $this->user1 = $user1;

        return $this;
    }

    public function getUser2(): ?Users
    {
        return $this->user2;
    }

    public function setUser2(?Users $user2): self
    {
        $this->user2 = $user2;

        return $this;
    }
}

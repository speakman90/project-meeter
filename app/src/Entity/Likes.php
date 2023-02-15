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

    #[ORM\OneToMany(mappedBy: 'like1', targetEntity: Users::class)]
    private Collection $like1;

    #[ORM\OneToMany(mappedBy: 'like2', targetEntity: Users::class)]
    private Collection $like2;

    #[ORM\Column(type: Types::DATE_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $dateMatch = null;

    #[ORM\Column]
    private ?bool $trash = null;

    #[ORM\OneToMany(mappedBy: 'likes', targetEntity: Messages::class)]
    private Collection $messages;

    public function __construct()
    {
        $this->like1 = new ArrayCollection();
        $this->like2 = new ArrayCollection();
        $this->messages = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return Collection<int, Users>
     */
    public function getLike1(): Collection
    {
        return $this->like1;
    }

    public function addLike1(Users $like1): self
    {
        if (!$this->like1->contains($like1)) {
            $this->like1->add($like1);
            $like1->setLike1($this);
        }

        return $this;
    }

    public function removeLike1(Users $like1): self
    {
        if ($this->like1->removeElement($like1)) {
            // set the owning side to null (unless already changed)
            if ($like1->getLike1() === $this) {
                $like1->setLike1(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Users>
     */
    public function getLike2(): Collection
    {
        return $this->like2;
    }

    public function addLike2(Users $like2): self
    {
        if (!$this->like2->contains($like2)) {
            $this->like2->add($like2);
            $like2->setLike2($this);
        }

        return $this;
    }

    public function removeLike2(Users $like2): self
    {
        if ($this->like2->removeElement($like2)) {
            // set the owning side to null (unless already changed)
            if ($like2->getLike2() === $this) {
                $like2->setLike2(null);
            }
        }

        return $this;
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
}

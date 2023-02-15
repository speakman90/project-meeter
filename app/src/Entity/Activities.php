<?php

namespace App\Entity;

use App\Repository\ActivitiesRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ActivitiesRepository::class)]
class Activities
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\ManyToMany(targetEntity: Users::class, inversedBy: 'activities')]
    private Collection $userActivity;

    public function __construct()
    {
        $this->userActivity = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return Collection<int, Users>
     */
    public function getUserActivity(): Collection
    {
        return $this->userActivity;
    }

    public function addUserActivity(Users $userActivity): self
    {
        if (!$this->userActivity->contains($userActivity)) {
            $this->userActivity->add($userActivity);
        }

        return $this;
    }

    public function removeUserActivity(Users $userActivity): self
    {
        $this->userActivity->removeElement($userActivity);

        return $this;
    }
}

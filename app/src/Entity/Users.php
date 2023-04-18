<?php

namespace App\Entity;

use App\Repository\UsersRepository;
use DateTime;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: UsersRepository::class)]
#[UniqueEntity(fields: ['email'], message: 'Cette email n\'est pas disponible')]
class Users implements UserInterface, PasswordAuthenticatedUserInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 180, unique: true)]
    private ?string $email = null;

    #[ORM\Column]
    private array $roles = [];

    /**
     * @var string The hashed password
     */
    #[ORM\Column]
    private ?string $password = null;

    #[ORM\Column(length: 255)]
    private ?string $userName = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $birthDate = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $createDate = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $biography = null;

    #[ORM\Column]
    // #[Assert\Count(
    //     max: 6,
    //     maxMessage: "Vous ne pouvez pas télécharger plus de {{ limit }} images."
    // )]
    // #[Assert\All(
    //     mimeTypes: ["image/jpeg", "image/png", "image/gif"],
    //     mimeTypesMessage: "Veuillez télécharger un fichier de type image (JPG, PNG, GIF)",
    // )]
    private array $profilPhotos = [];

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $city = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $job = null;

    #[ORM\ManyToOne(inversedBy: 'Users')]
    private ?Gender $gender = null;

    #[ORM\Column]
    private array $Orientations = [];

    #[ORM\ManyToMany(targetEntity: Activities::class, mappedBy: 'userActivity')]
    private Collection $activities;

    #[ORM\OneToMany(mappedBy: 'userSender', targetEntity: Messages::class)]
    private Collection $messages;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $lastLocation = null;

    #[ORM\Column(type: 'boolean')]
    private $isVerified = false;

    #[ORM\OneToMany(mappedBy: 'user1', targetEntity: Likes::class)]
    private Collection $user1;

    #[ORM\OneToMany(mappedBy: 'user2', targetEntity: Likes::class)]
    private Collection $user2;

    public function __construct()
    {
        $this->createDate = new \DateTimeImmutable();
        $this->activities = new ArrayCollection();
        $this->messages = new ArrayCollection();
        $this->user1 = new ArrayCollection();
        $this->user2 = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUserIdentifier(): string
    {
        return (string) $this->email;
    }

    /**
     * @deprecated since Symfony 5.3, use getUserIdentifier instead
     */
    public function getUsername(): string
    {
        return (string) $this->userName;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    public function setRoles(array $roles): self
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see PasswordAuthenticatedUserInterface
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    /**
     * Returning a salt is only needed, if you are not using a modern
     * hashing algorithm (e.g. bcrypt or sodium) in your security.yaml.
     *
     * @see UserInterface
     */
    public function getSalt(): ?string
    {
        return null;
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials()
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }

    public function setUserName(string $userName): self
    {
        $this->userName = $userName;

        return $this;
    }

    public function getBirthDate(): ?\DateTimeInterface
    {
        return $this->birthDate;
    }

    public function setBirthDate(\DateTimeInterface $birthDate): self
    {
        $this->birthDate = $birthDate;

        return $this;
    }

    public function getAge()
    {
        $date_actuelle = new DateTime();
        $diff = $date_actuelle->diff($this->birthDate);
        return  $diff->y;
    }

    public function getCreateDate(): ?\DateTimeInterface
    {
        return $this->createDate;
    }

    public function setCreateDate(\DateTimeInterface $createDate): self
    {
        $this->createDate = $createDate;

        return $this;
    }

    public function getBiography(): ?string
    {
        return $this->biography;
    }

    public function setBiography(?string $biography): self
    {
        $this->biography = $biography;

        return $this;
    }

    public function getProfilPhotos(): array
    {
        return $this->profilPhotos;
    }

    public function setProfilPhotos(array $profilPhotos): self
    {
        $this->profilPhotos = $profilPhotos;

        return $this;
    }

    public function getCity(): ?string
    {
        return $this->city;
    }

    public function setCity(?string $city): self
    {
        $this->city = $city;

        return $this;
    }

    public function getJob(): ?string
    {
        return $this->job;
    }

    public function setJob(?string $job): self
    {
        $this->job = $job;

        return $this;
    }

    public function getGender(): ?Gender
    {
        return $this->gender;
    }

    public function setGender(?Gender $gender): self
    {
        $this->gender = $gender;

        return $this;
    }

    public function getOrientations(): array
    {
        return $this->Orientations;
    }

    public function setOrientations(array $Orientations): self
    {
        $this->Orientations = $Orientations;

        return $this;
    }

    /**
     * @return Collection<int, Activities>
     */
    public function getActivities(): Collection
    {
        return $this->activities;
    }

    public function addActivity(Activities $activity): self
    {
        if (!$this->activities->contains($activity)) {
            $this->activities->add($activity);
            $activity->addUserActivity($this);
        }

        return $this;
    }

    public function removeActivity(Activities $activity): self
    {
        if ($this->activities->removeElement($activity)) {
            $activity->removeUserActivity($this);
        }

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
            $message->setUserSender($this);
        }

        return $this;
    }

    public function removeMessage(Messages $message): self
    {
        if ($this->messages->removeElement($message)) {
            // set the owning side to null (unless already changed)
            if ($message->getUserSender() === $this) {
                $message->setUserSender(null);
            }
        }

        return $this;
    }

    public function getLastLocation(): ?string
    {
        return $this->lastLocation;
    }

    public function setLastLocation(?string $lastLocation): self
    {
        $this->lastLocation = $lastLocation;

        return $this;
    }

    public function isVerified(): bool
    {
        return $this->isVerified;
    }

    public function getIsVerified(): bool
    {
        return $this->isVerified;
    }

    public function setIsVerified(bool $isVerified): self
    {
        $this->isVerified = $isVerified;

        return $this;
    }

    /**
     * @return Collection<int, Likes>
     */
    public function getUser1(): Collection
    {
        return $this->user1;
    }

    public function addUser1(Likes $user1): self
    {
        if (!$this->user1->contains($user1)) {
            $this->user1->add($user1);
            $user1->setUser1($this);
        }

        return $this;
    }

    public function removeUser1(Likes $user1): self
    {
        if ($this->user1->removeElement($user1)) {
            // set the owning side to null (unless already changed)
            if ($user1->getUser1() === $this) {
                $user1->setUser1(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Likes>
     */
    public function getUser2(): Collection
    {
        return $this->user2;
    }

    public function addUser2(Likes $user2): self
    {
        if (!$this->user2->contains($user2)) {
            $this->user2->add($user2);
            $user2->setUser2($this);
        }

        return $this;
    }

    public function removeUser2(Likes $user2): self
    {
        if ($this->user2->removeElement($user2)) {
            // set the owning side to null (unless already changed)
            if ($user2->getUser2() === $this) {
                $user2->setUser2(null);
            }
        }

        return $this;
    }

    /**
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }

}

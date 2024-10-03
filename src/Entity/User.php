<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: UserRepository::class)]
#[UniqueEntity('email')]
class User implements PasswordAuthenticatedUserInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank]
    private ?string $name = null;

    #[ORM\Column(type: Types::TEXT)]
    #[Assert\NotBlank]
    private ?string $password = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank]
    #[Assert\Email]
    private ?string $email = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $token = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $logo = null;

    #[ORM\Column(length: 255)]
    private ?string $role = null;

    /**
     * @var Collection<int, TrickComment>
     */
    #[ORM\OneToMany(targetEntity: TrickComment::class, mappedBy: 'user', orphanRemoval: true)]
    private Collection $trickComments;

    /**
     * @var Collection<int, ChatRoom>
     */
    #[ORM\OneToMany(targetEntity: ChatRoom::class, mappedBy: 'user', orphanRemoval: true)]
    private Collection $chatRooms;

    public function __construct()
    {
        $this->trickComments = new ArrayCollection();
        $this->chatRooms = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;

        return $this;
    }

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(string $password): static
    {
        $this->password = $password;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): static
    {
        $this->email = $email;

        return $this;
    }

    public function getToken(): ?string
    {
        return $this->token;
    }

    public function setToken(?string $token): static
    {
        $this->token = $token;

        return $this;
    }

    public function getLogo(): ?string
    {
        return $this->logo;
    }

    public function setLogo(?string $logo): static
    {
        $this->logo = $logo;

        return $this;
    }

    public function getRole(): ?string
    {
        return $this->role;
    }

    public function setRole(string $role): static
    {
        $this->role = $role;

        return $this;
    }

    /**
     * @return Collection<int, TrickComment>
     */
    public function getTrickComments(): Collection
    {
        return $this->trickComments;
    }

    public function addTrickComment(TrickComment $trickComment): static
    {
        if (!$this->trickComments->contains($trickComment)) {
            $this->trickComments->add($trickComment);
            $trickComment->setUser($this);
        }

        return $this;
    }

    public function removeTrickComment(TrickComment $trickComment): static
    {
        if ($this->trickComments->removeElement($trickComment)) {
            // set the owning side to null (unless already changed)
            if ($trickComment->getUser() === $this) {
                $trickComment->setUser(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, ChatRoom>
     */
    public function getChatRooms(): Collection
    {
        return $this->chatRooms;
    }

    public function addChatRoom(ChatRoom $chatRoom): static
    {
        if (!$this->chatRooms->contains($chatRoom)) {
            $this->chatRooms->add($chatRoom);
            $chatRoom->setUser($this);
        }

        return $this;
    }

    public function removeChatRoom(ChatRoom $chatRoom): static
    {
        if ($this->chatRooms->removeElement($chatRoom)) {
            // set the owning side to null (unless already changed)
            if ($chatRoom->getUser() === $this) {
                $chatRoom->setUser(null);
            }
        }

        return $this;
    }
}

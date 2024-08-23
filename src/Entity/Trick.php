<?php

namespace App\Entity;

use App\Repository\TrickRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: TrickRepository::class)]
class Trick
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $description = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $createdAt = null;

    #[ORM\Column(nullable: true)]
    private ?\DateTimeImmutable $updatedAt = null;

    #[ORM\ManyToOne(inversedBy: 'tricks')]
    #[ORM\JoinColumn(nullable: false)]
    private ?TrickGroup $trickGroup = null;

    /**
     * @var Collection<int, TrickPicture>
     */
    #[ORM\ManyToMany(targetEntity: TrickPicture::class, mappedBy: 'tricks')]
    private Collection $trickPictures;

    /**
     * @var Collection<int, TrickVideo>
     */
    #[ORM\ManyToMany(targetEntity: TrickVideo::class, mappedBy: 'tricks')]
    private Collection $trickVideos;

    /**
     * @var Collection<int, TrickComment>
     */
    #[ORM\OneToMany(targetEntity: TrickComment::class, mappedBy: 'trick', orphanRemoval: true)]
    private Collection $comments;

    public function __construct()
    {
        $this->trickPictures = new ArrayCollection();
        $this->trickVideos = new ArrayCollection();
        $this->comments = new ArrayCollection();
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

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): static
    {
        $this->description = $description;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeImmutable $createdAt): static
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getUpdatedAt(): ?\DateTimeImmutable
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(?\DateTimeImmutable $updatedAt): static
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    public function getTrickGroup(): ?TrickGroup
    {
        return $this->trickGroup;
    }

    public function setTrickGroup(?TrickGroup $trickGroup): static
    {
        $this->trickGroup = $trickGroup;

        return $this;
    }

    /**
     * @return Collection<int, TrickPicture>
     */
    public function getTrickPictures(): Collection
    {
        return $this->trickPictures;
    }

    public function addTrickPicture(TrickPicture $trickPicture): static
    {
        if (!$this->trickPictures->contains($trickPicture)) {
            $this->trickPictures->add($trickPicture);
            $trickPicture->addTrick($this);
        }

        return $this;
    }

    public function removeTrickPicture(TrickPicture $trickPicture): static
    {
        if ($this->trickPictures->removeElement($trickPicture)) {
            $trickPicture->removeTrick($this);
        }

        return $this;
    }

    /**
     * @return Collection<int, TrickVideo>
     */
    public function getTrickVideos(): Collection
    {
        return $this->trickVideos;
    }

    public function addTrickVideo(TrickVideo $trickVideo): static
    {
        if (!$this->trickVideos->contains($trickVideo)) {
            $this->trickVideos->add($trickVideo);
            $trickVideo->addTrick($this);
        }

        return $this;
    }

    public function removeTrickVideo(TrickVideo $trickVideo): static
    {
        if ($this->trickVideos->removeElement($trickVideo)) {
            $trickVideo->removeTrick($this);
        }

        return $this;
    }

    /**
     * @return Collection<int, TrickComment>
     */
    public function getComments(): Collection
    {
        return $this->comments;
    }

    public function addComment(TrickComment $comment): static
    {
        if (!$this->comments->contains($comment)) {
            $this->comments->add($comment);
            $comment->setTrick($this);
        }

        return $this;
    }

    public function removeComment(TrickComment $comment): static
    {
        if ($this->comments->removeElement($comment)) {
            // set the owning side to null (unless already changed)
            if ($comment->getTrick() === $this) {
                $comment->setTrick(null);
            }
        }

        return $this;
    }

    public function getOldestPicture(): ?TrickPicture
    {
        $oldestPicture = null;
        foreach ($this->trickPictures as $picture) {
            if(null === $picture->getCreatedAt()) {
                continue;
            }

            /** @var TrickPicture $oldestPicture */
            if($oldestPicture === null || $picture->getCreatedAt() < $oldestPicture->getCreatedAt()) {
                $oldestPicture = $picture;
            }
        }

        return $oldestPicture;
    }
}

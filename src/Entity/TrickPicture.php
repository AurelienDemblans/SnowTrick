<?php

namespace App\Entity;

use App\Repository\TrickPictureRepository;
use DateTimeImmutable;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

#[ORM\Entity(repositoryClass: TrickPictureRepository::class)]
#[UniqueEntity('isHomepage')]
class TrickPicture
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $url = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $createdAt = null;

    #[ORM\ManyToOne(inversedBy: 'trickPictures')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Trick $trick = null;

    #[ORM\Column(nullable: true)]
    private ?bool $isHomepage = null;

    #[ORM\Column(nullable: true)]
    private ?bool $isMainPicture = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUrl(): ?string
    {
        return $this->url;
    }

    public function setUrl(string $url): static
    {
        $this->url = $url;

        return $this;
    }

    public function getTrick(): ?Trick
    {
        return $this->trick;
    }

    public function setTrick(?Trick $trick): static
    {
        $this->trick = $trick;

        return $this;
    }

    public function getCreatedAt(): ?DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function setCreatedAt(DateTimeImmutable $createdAt): static
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function isHomepage(): ?bool
    {
        return $this->isHomepage;
    }

    public function setHomepage(?bool $isHomepage): static
    {
        $this->isHomepage = $isHomepage;

        return $this;
    }

    public function isMainPicture(): ?bool
    {
        return $this->isMainPicture;
    }

    public function setMainPicture(?bool $isMainPicture): static
    {
        $this->isMainPicture = $isMainPicture;

        return $this;
    }
}

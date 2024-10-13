<?php

namespace App\Entity;

use App\Repository\TrickVideoRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: TrickVideoRepository::class)]
class TrickVideo
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $url = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $createdAt = null;

    /**
     * @var Collection<int, Trick>
     */
    #[ORM\ManyToMany(targetEntity: Trick::class, inversedBy: 'trickVideos')]
    private Collection $tricks;

    #[ORM\Column]
    private ?bool $isExternalUrl = false;

    public function __construct()
    {
        $this->tricks = new ArrayCollection();
    }

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

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeImmutable $createdAt): static
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    /**
     * @return Collection<int, Trick>
     */
    public function getTricks(): Collection
    {
        return $this->tricks;
    }

    public function addTrick(Trick $trick): static
    {
        if (!$this->tricks->contains($trick)) {
            $this->tricks->add($trick);
        }

        return $this;
    }

    public function removeTrick(Trick $trick): static
    {
        $this->tricks->removeElement($trick);

        return $this;
    }

    public function isExternalUrl(): ?bool
    {
        return $this->isExternalUrl;
    }

    public function setExternalUrl(bool $isExternalUrl): static
    {
        $this->isExternalUrl = $isExternalUrl;

        return $this;
    }
}

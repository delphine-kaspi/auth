<?php

namespace App\Entity;

use App\Repository\SpectacleRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: SpectacleRepository::class)]
class Spectacle
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 150)]
    private ?string $titre = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $description = null;

    #[ORM\Column]
    private ?int $duree = null;

    #[ORM\ManyToOne(inversedBy: 'spectacles')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Artiste $artiste = null;

    /**
     * @var Collection<int, Representation>
     */
    #[ORM\OneToMany(targetEntity: Representation::class, mappedBy: 'spectacle')]
    private Collection $representations;

    public function __construct()
    {
        $this->representations = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitre(): ?string
    {
        return $this->titre;
    }

    public function setTitre(string $titre): static
    {
        $this->titre = $titre;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): static
    {
        $this->description = $description;

        return $this;
    }

    public function getDuree(): ?int
    {
        return $this->duree;
    }

    public function setDuree(int $duree): static
    {
        $this->duree = $duree;

        return $this;
    }

    public function getArtiste(): ?Artiste
    {
        return $this->artiste;
    }

    public function setArtiste(?Artiste $artiste): static
    {
        $this->artiste = $artiste;

        return $this;
    }

    /**
     * @return Collection<int, Representation>
     */
    public function getRepresentations(): Collection
    {
        return $this->representations;
    }

    public function addRepresentation(Representation $representation): static
    {
        if (!$this->representations->contains($representation)) {
            $this->representations->add($representation);
            $representation->setSpectacle($this);
        }

        return $this;
    }

    public function removeRepresentation(Representation $representation): static
    {
        if ($this->representations->removeElement($representation)) {
            // set the owning side to null (unless already changed)
            if ($representation->getSpectacle() === $this) {
                $representation->setSpectacle(null);
            }
        }

        return $this;
    }
}

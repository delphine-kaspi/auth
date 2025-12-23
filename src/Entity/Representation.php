<?php

namespace App\Entity;

use App\Repository\RepresentationRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: RepresentationRepository::class)]
class Representation
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTime $dateRepresentation = null;

    #[ORM\Column(type: Types::TIME_MUTABLE)]
    private ?\DateTime $heureRepresentation = null;

    #[ORM\Column(type: Types::DECIMAL, precision: 6, scale: 2)]
    private ?string $prix = null;

    #[ORM\ManyToOne(inversedBy: 'representations')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Salle $salle = null;

    #[ORM\ManyToOne(inversedBy: 'representations')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Spectacle $spectacle = null;

    /**
     * @var Collection<int, Reservation>
     */
    #[ORM\OneToMany(targetEntity: Reservation::class, mappedBy: 'representation')]
    private Collection $reservations;

    public function __construct()
    {
        $this->reservations = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDateRepresentation(): ?\DateTime
    {
        return $this->dateRepresentation;
    }

    public function setDateRepresentation(\DateTime $dateRepresentation): static
    {
        $this->dateRepresentation = $dateRepresentation;

        return $this;
    }

    public function getHeureRepresentation(): ?\DateTime
    {
        return $this->heureRepresentation;
    }

    public function setHeureRepresentation(\DateTime $heureRepresentation): static
    {
        $this->heureRepresentation = $heureRepresentation;

        return $this;
    }

    public function getPrix(): ?string
    {
        return $this->prix;
    }

    public function setPrix(string $prix): static
    {
        $this->prix = $prix;

        return $this;
    }

    public function getSalle(): ?Salle
    {
        return $this->salle;
    }

    public function setSalle(?Salle $salle): static
    {
        $this->salle = $salle;

        return $this;
    }

    public function getSpectacle(): ?Spectacle
    {
        return $this->spectacle;
    }

    public function setSpectacle(?Spectacle $spectacle): static
    {
        $this->spectacle = $spectacle;

        return $this;
    }

    /**
     * @return Collection<int, Reservation>
     */
    public function getReservations(): Collection
    {
        return $this->reservations;
    }

    public function addReservation(Reservation $reservation): static
    {
        if (!$this->reservations->contains($reservation)) {
            $this->reservations->add($reservation);
            $reservation->setRepresentation($this);
        }

        return $this;
    }

    public function removeReservation(Reservation $reservation): static
    {
        if ($this->reservations->removeElement($reservation)) {
            // set the owning side to null (unless already changed)
            if ($reservation->getRepresentation() === $this) {
                $reservation->setRepresentation(null);
            }
        }

        return $this;
    }
}

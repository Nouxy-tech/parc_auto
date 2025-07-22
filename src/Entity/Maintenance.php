<?php

namespace App\Entity;

use App\Repository\MaintenanceRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: MaintenanceRepository::class)]
class Maintenance
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $date = null;

    #[ORM\Column(length: 255)]
    private ?string $type = null;

    #[ORM\Column]
    private ?float $cout = null;

    #[ORM\ManyToOne(targetEntity: self::class, inversedBy: 'Voiture')]
    private ?self $voiture = null;

    #[ORM\OneToMany(mappedBy: 'voiture', targetEntity: self::class)]
    private Collection $Voiture;

    public function __construct()
    {
        $this->Voiture = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDate(): ?\DateTimeInterface
    {
        return $this->date;
    }

    public function setDate(\DateTimeInterface $date): static
    {
        $this->date = $date;

        return $this;
    }

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(string $type): static
    {
        $this->type = $type;

        return $this;
    }

    public function getCout(): ?float
    {
        return $this->cout;
    }

    public function setCout(float $cout): static
    {
        $this->cout = $cout;

        return $this;
    }

    public function getVoiture(): ?self
    {
        return $this->voiture;
    }

    public function setVoiture(?self $voiture): static
    {
        $this->voiture = $voiture;

        return $this;
    }

    public function addVoiture(self $voiture): static
    {
        if (!$this->Voiture->contains($voiture)) {
            $this->Voiture->add($voiture);
            $voiture->setVoiture($this);
        }

        return $this;
    }

    public function removeVoiture(self $voiture): static
    {
        if ($this->Voiture->removeElement($voiture)) {
            // set the owning side to null (unless already changed)
            if ($voiture->getVoiture() === $this) {
                $voiture->setVoiture(null);
            }
        }

        return $this;
    }
}

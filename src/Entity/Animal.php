<?php

namespace App\Entity;

use App\Repository\AnimalRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: AnimalRepository::class)]
class Animal
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 50)]
    private ?string $name = null;

    #[ORM\Column]
    private ?int $age = null;

    #[ORM\Column(length: 20)]
    private ?string $status = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $description = null;

    /**
     * @var Collection<int, Caretaker>
     */
    #[ORM\ManyToMany(targetEntity: Caretaker::class, inversedBy: 'animals')]
    private Collection $caretaker;

    #[ORM\ManyToOne(inversedBy: 'animals')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Shelter $shelter = null;

    #[ORM\ManyToOne(inversedBy: 'animals')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Species $species = null;

    /**
     * @var Collection<int, Adoption>
     */
    #[ORM\OneToMany(targetEntity: Adoption::class, mappedBy: 'animal', orphanRemoval: true)]
    private Collection $adoptions;

    public function __construct()
    {
        $this->caretaker = new ArrayCollection();
        $this->adoptions = new ArrayCollection();
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

    public function getAge(): ?int
    {
        return $this->age;
    }

    public function setAge(int $age): static
    {
        $this->age = $age;

        return $this;
    }

    public function getStatus(): ?string
    {
        return $this->status;
    }

    public function setStatus(string $status): static
    {
        $this->status = $status;

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

    /**
     * @return Collection<int, Caretaker>
     */
    public function getCaretaker(): Collection
    {
        return $this->caretaker;
    }

    public function addCaretaker(Caretaker $caretaker): static
    {
        if (!$this->caretaker->contains($caretaker)) {
            $this->caretaker->add($caretaker);
        }

        return $this;
    }

    public function removeCaretaker(Caretaker $caretaker): static
    {
        $this->caretaker->removeElement($caretaker);

        return $this;
    }

    public function getShelter(): ?Shelter
    {
        return $this->shelter;
    }

    public function setShelter(?Shelter $shelter): static
    {
        $this->shelter = $shelter;

        return $this;
    }

    public function getSpecies(): ?Species
    {
        return $this->species;
    }

    public function setSpecies(?Species $species): static
    {
        $this->species = $species;

        return $this;
    }

    /**
     * @return Collection<int, Adoption>
     */
    public function getAdoptions(): Collection
    {
        return $this->adoptions;
    }

    public function addAdoption(Adoption $adoption): static
    {
        if (!$this->adoptions->contains($adoption)) {
            $this->adoptions->add($adoption);
            $adoption->setAnimal($this);
        }

        return $this;
    }

    public function removeAdoption(Adoption $adoption): static
    {
        if ($this->adoptions->removeElement($adoption)) {
            // set the owning side to null (unless already changed)
            if ($adoption->getAnimal() === $this) {
                $adoption->setAnimal(null);
            }
        }

        return $this;
    }
}

<?php

namespace App\Entity;

use App\Repository\ShelterRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ShelterRepository::class)]
class Shelter
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 50)]
    private ?string $name = null;

    #[ORM\Column(length: 100)]
    private ?string $address = null;

    #[ORM\Column(length: 20, nullable: true)]
    private ?string $phone = null;

    #[ORM\Column(length: 50)]
    private ?string $email = null;

    /**
     * @var Collection<int, Animal>
     */
    #[ORM\OneToMany(targetEntity: Animal::class, mappedBy: 'shelter')]
    private Collection $animals;

    /**
     * @var Collection<int, Caretaker>
     */
    #[ORM\ManyToMany(targetEntity: Caretaker::class, mappedBy: 'shelter')]
    private Collection $caretakers;

    public function __construct()
    {
        $this->animals = new ArrayCollection();
        $this->caretakers = new ArrayCollection();
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

    public function getAddress(): ?string
    {
        return $this->address;
    }

    public function setAddress(string $address): static
    {
        $this->address = $address;

        return $this;
    }

    public function getPhone(): ?string
    {
        return $this->phone;
    }

    public function setPhone(?string $phone): static
    {
        $this->phone = $phone;

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

    /**
     * @return Collection<int, Animal>
     */
    public function getAnimals(): Collection
    {
        return $this->animals;
    }

    public function addAnimal(Animal $animal): static
    {
        if (!$this->animals->contains($animal)) {
            $this->animals->add($animal);
            $animal->setShelter($this);
        }

        return $this;
    }

    public function removeAnimal(Animal $animal): static
    {
        if ($this->animals->removeElement($animal)) {
            // set the owning side to null (unless already changed)
            if ($animal->getShelter() === $this) {
                $animal->setShelter(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Caretaker>
     */
    public function getCaretakers(): Collection
    {
        return $this->caretakers;
    }

    public function addCaretaker(Caretaker $caretaker): static
    {
        if (!$this->caretakers->contains($caretaker)) {
            $this->caretakers->add($caretaker);
            $caretaker->addShelter($this);
        }

        return $this;
    }

    public function removeCaretaker(Caretaker $caretaker): static
    {
        if ($this->caretakers->removeElement($caretaker)) {
            $caretaker->removeShelter($this);
        }

        return $this;
    }
}

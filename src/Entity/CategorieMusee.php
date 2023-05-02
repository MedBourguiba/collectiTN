<?php

namespace App\Entity;

use App\Repository\CategorieMuseeRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CategorieMuseeRepository::class)]
class CategorieMusee
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\OneToMany(mappedBy: 'categorie', targetEntity: Musee::class, orphanRemoval: true)]
    private Collection $musees;
    public function __toString() {
        return $this->name;
      }
    public function __construct()
    {
        $this->musees = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return Collection<int, Musee>
     */
    public function getMusees(): Collection
    {
        return $this->musees;
    }

    public function addMusee(Musee $musee): self
    {
        if (!$this->musees->contains($musee)) {
            $this->musees->add($musee);
            $musee->setCategorie($this);
        }

        return $this;
    }

    public function removeMusee(Musee $musee): self
    {
        if ($this->musees->removeElement($musee)) {
            // set the owning side to null (unless already changed)
            if ($musee->getCategorie() === $this) {
                $musee->setCategorie(null);
            }
        }

        return $this;
    }
}

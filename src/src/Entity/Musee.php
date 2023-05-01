<?php

namespace App\Entity;

use App\Repository\MuseeRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: MuseeRepository::class)]
class Musee
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column(length: 255)]
    private ?string $description = null;

    #[ORM\Column(length: 255)]
    private ?string $img = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $createdAt = null;

    #[ORM\ManyToOne(inversedBy: 'musees')]
    #[ORM\JoinColumn(nullable: false)]
    private ?CategorieMusee $categorie = null;

    #[ORM\OneToMany(mappedBy: 'musee', targetEntity: PieceMusee::class, orphanRemoval: true)]
    private Collection $piecesMusees;

    public function __construct()
    {
        $this->piecesMusees = new ArrayCollection();
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

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getImg(): ?string
    {
        return $this->img;
    }

    public function setImg(string $img): self
    {
        $this->img = $img;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeImmutable $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getCategorie(): ?CategorieMusee
    {
        return $this->categorie;
    }

    public function setCategorie(?CategorieMusee $categorie): self
    {
        $this->categorie = $categorie;

        return $this;
    }

    /**
     * @return Collection<int, PieceMusee>
     */
    public function getPiecesMusees(): Collection
    {
        return $this->piecesMusees;
    }

    public function addPiecesMusee(PieceMusee $piecesMusee): self
    {
        if (!$this->piecesMusees->contains($piecesMusee)) {
            $this->piecesMusees->add($piecesMusee);
            $piecesMusee->setMusee($this);
        }

        return $this;
    }

    public function removePiecesMusee(PieceMusee $piecesMusee): self
    {
        if ($this->piecesMusees->removeElement($piecesMusee)) {
            // set the owning side to null (unless already changed)
            if ($piecesMusee->getMusee() === $this) {
                $piecesMusee->setMusee(null);
            }
        }

        return $this;
    }
}

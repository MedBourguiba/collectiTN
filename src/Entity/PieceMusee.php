<?php

namespace App\Entity;

use App\Repository\PieceMuseeRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PieceMuseeRepository::class)]
class PieceMusee
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
    private ?\DateTimeImmutable $postedAt = null;

    #[ORM\ManyToOne(inversedBy: 'piecesMusees')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Musee $musee = null;
    public function __toString() {
        return $this->name;
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

    public function getPostedAt(): ?\DateTimeImmutable
    {
        return $this->postedAt;
    }

    public function setPostedAt(\DateTimeImmutable $postedAt): self
    {
        $this->postedAt = $postedAt;

        return $this;
    }

    public function getMusee(): ?Musee
    {
        return $this->musee;
    }

    public function setMusee(?Musee $musee): self
    {
        $this->musee = $musee;

        return $this;
    }
}

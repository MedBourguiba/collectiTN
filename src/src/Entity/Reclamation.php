<?php

namespace App\Entity;

use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\ReclamationRepository;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: ReclamationRepository::class)]
class Reclamation
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: "integer")]
    private ?int $id = null;

    #[ORM\Column(type: "string", length: 255)]
    #[Assert\NotBlank(message: 'sujet vide')]
    private ?string $sujet = null;

    #[ORM\Column(type: "text", length: 65535)]
    #[Assert\NotBlank(message: 'message vide')]
    private ?string $message = null;

    #[ORM\Column(type: "datetime")]
    private ?\DateTimeInterface $dateReclamation = null;

    #[ORM\ManyToOne(targetEntity: Item::class)]
    #[ORM\JoinColumn(nullable: true)]
    private ?Item $item = null;

    #[ORM\ManyToOne(targetEntity: "Utilisateur")]
    #[ORM\JoinColumn(name: "user_id", referencedColumnName: "id")]
    private ?Utilisateur $user = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getSujet(): ?string
    {
        return $this->sujet;
    }

    public function setSujet(string $sujet): self
    {
        $this->sujet = $sujet;

        return $this;
    }

    public function getMessage(): ?string
    {
        return $this->message;
    }

    public function setMessage(string $message): self
    {
        $this->message = $message;

        return $this;
    }

    public function getDateReclamation(): ?\DateTimeInterface
    {
        return $this->dateReclamation;
    }

    public function setDateReclamation(\DateTimeInterface $dateReclamation): self
    {
        $this->dateReclamation = $dateReclamation;

        return $this;
    }

    public function getItem(): ?Items
    {
        return $this->item;
    }

    public function setItem(?Items $item): self
    {
        $this->item = $item;

        return $this;
    }

    public function getUser(): ?Users
    {
        return $this->user;
    }

    public function setUser(?Users $user): self
    {
        $this->user = $user;

        return $this;
    }

    public function validate()
    {
        if (empty($this->sujet)) {
            throw new \Exception('Le sujet de la réclamation ne doit pas être vide');
        }

        if (empty($this->message)) {
            throw new \Exception('Le message de la réclamation ne doit pas être vide');
        }
    }
}

<?php

namespace App\Entity;


use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\ReclamationRepository;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: ReclamationRepository::class)]
#[ApiResource]
class Reclamation
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: "integer")]
    private ?int $id = null;

    #[ORM\Column(type: "string", length: 255)]
    #[Assert\NotBlank(message: 'Le sujet de la réclamation ne doit pas être vide')]
    private ?string $sujet = null;

    #[ORM\Column(type: "text", length: 65535)]
    #[Assert\NotBlank(message: 'Le message de la réclamation ne doit pas être vide')]
    private ?string $message = null;

    #[ORM\Column(type: "datetime", nullable: false)]
    private ?\DateTimeInterface $dateReclamation = null;
    
    #[ORM\ManyToOne(targetEntity: Item::class)]
    #[ORM\JoinColumn(nullable: true)]
    private ?Item $item = null;

    #[ORM\ManyToOne(targetEntity: "Utilisateur")]
    #[ORM\JoinColumn(name: "user_id", referencedColumnName: "id")]
    private ?Utilisateur $user = null;

    #[ORM\Column(type: "string", length: 255)]
    #[Assert\NotBlank(message: 'Le nom ne doit pas être vide')]
    private ?string $name = null;

    #[ORM\Column(type: "string", length: 255)]
    #[Assert\NotBlank(message: 'L\'email ne doit pas être vide')]
    #[Assert\Email(message: 'L\'email "{{ value }}" n\'est pas valide.')]
    private ?string $email = null;

    public function __construct()
    {
        $this->dateReclamation = new \DateTime();
    }

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

    public function getItem(): ?Item
    {
        return $this->item;
    }

    public function setItem(?Item $item): self
    {
        $this->item = $item;

        return $this;
    }

    public function getUser(): ?Utilisateur
    {
        return $this->user;
    }

    public function setUser(?Utilisateur $user): self
    {
        $this->user = $user;

        return $this;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(?string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
   
    }
    public function setEmail(?string $email): self
    {
        $this->email = $email;

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
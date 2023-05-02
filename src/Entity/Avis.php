<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\AvisRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;


#[ORM\Entity(repositoryClass: AvisRepository::class)]
#[ApiResource]
class Avis
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private ?int $id = null;

    /**
     * @ORM\Column(type="integer")
     * @Assert\NotBlank(message="Veuillez indiquer une note.")
     * @Assert\Range(
     *     min=1,
     *     max=5,
     *     notInRangeMessage="La note doit être comprise entre {{ min }} et {{ max }}.",
     *     invalidMessage="Veuillez indiquer une note valide."
     * )
     */
    private ?int $note = null;

    #[ORM\Column(type: 'text', nullable: true)]
    private ?string $commentaire = null;

    #[ORM\Column(type: 'datetime', nullable: false)]
    private ?\DateTimeInterface $dateAvis = null;

    #[ORM\ManyToOne(targetEntity: Utilisateur::class)]
    #[ORM\JoinColumn(nullable: true)]
    private ?Utilisateur $client = null;

    #[ORM\OneToOne(cascade: ['persist', 'remove'])]
    #[ORM\JoinColumn(nullable: false)]
    private ?Utilisateur $Partenaire = null;
    public function __construct()
    {
        $this->dateAvis = new \DateTimeImmutable();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNote(): ?int
    {
        return $this->note;
    }

    public function setNote(?int $note): self
    {
        $this->note = $note;

        return $this;
    }

    public function getCommentaire(): ?string
    {
        return $this->commentaire;
    }

    public function setCommentaire(?string $commentaire): self
    {
        $this->commentaire = $commentaire;

        return $this;
    }

    public function getDateAvis(): ?\DateTimeInterface
    {
        return $this->dateAvis;
    }

    public function setDateAvis(\DateTimeInterface $dateAvis): self
    {
        $this->dateAvis = $dateAvis;

        return $this;
    }
 

    public function getClient(): ?Utilisateur
    {
        return $this->client;
    }

    public function setClient(?utilisateur $user): self
    {
        $this->client = $user;

        return $this;
    }

    public function getPartenaire(): ?Utilisateur
    {
        return $this->Partenaire;
    }

    public function setPartenaire(Utilisateur $Partenaire): self
    {
        $this->Partenaire = $Partenaire;

        return $this;
    }
}

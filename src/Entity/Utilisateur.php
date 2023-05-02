<?php

namespace App\Entity;

use App\Type\Enum\UserRoleEnum;
use App\Type\UserRoleEnumType;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Vich\UploaderBundle\Mapping\Annotation as Vich;
use Symfony\Component\HttpFoundation\File\File;


/**
 * Utilisateur
 */
#[ORM\Table(name: "utilisateur")]
#[ORM\Entity]
#[UniqueEntity(fields: ['email'], message: 'There is already an account with this email')]
#[Vich\Uploadable]
class Utilisateur implements UserInterface, PasswordAuthenticatedUserInterface
{
    #[ORM\Id]
    #[ORM\Column(type: "integer", nullable: false)]
    #[ORM\GeneratedValue(strategy: "IDENTITY")]
    private int $id;

    #[ORM\Column(type: "string", length: 50, nullable: false)]
    #[Assert\NotBlank(message: "Le nom ne doit pas être vide")]
    #[Assert\Length(max: 10, maxMessage: "Le nom ne doit pas dépasser {{ limit }} caractères")]
    #[Assert\Regex(pattern: "/^[^0-9]+$/", message: "Le nom ne doit pas contenir de chiffres")]
    private string $nom;

    #[ORM\Column(type: "string", length: 50, nullable: false)]
    #[Assert\NotBlank(message: "Le prenom ne doit pas être vide")]
    #[Assert\Length(max: 10, maxMessage: "Le prenom ne doit pas dépasser {{ limit }} caractères")]
    #[Assert\Regex(pattern: "/^[^0-9]+$/", message: "Le nom ne doit pas contenir de chiffres")]
    private string $prenom;

    #[ORM\Column(type: "user_role_enum", nullable: false)]
    private $roles;

    #[ORM\Column(type: "integer", nullable: false)]
    #[Assert\NotBlank(message: "Le numéro de telephone ne doit pas être vide")]
    #[Assert\Length(min: 8, max: 8)]
    private int $telephone;

    #[ORM\Column(type: "string", length: 50, nullable: false)]
    #[Assert\NotBlank(message: "L'email ne doit pas être vide")]
    #[Assert\Regex(pattern: "/.*@.*$/", message: "L adresse email doit contenir le symbole @")]
    private string $email;

    #[ORM\Column(type: "string", length: 255, nullable: false)]
    
    private string $password;

    #[ORM\Column(type: "date", nullable: false)]
    private \DateTime $datenaiss;

    #[ORM\Column(type: "boolean")]
    private bool $isVerified = false;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $img = null;

    #[Vich\UploadableField(mapping: 'item_image', fileNameProperty: 'img')]
    private ?File $imgFile = null;


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): self
    {
        $this->nom = $nom;

        return $this;
    }

    public function getPrenom(): ?string
    {
        return $this->prenom;
    }

    public function setPrenom(string $prenom): self
    {
        $this->prenom = $prenom;

        return $this;
    }

    public function getRoles(): array
    {
        return (array)$this->roles;
    }

    public function setRoles(array $roles): self
    {
        foreach ($roles as $roles) {
            if (!in_array($roles, UserRoleEnum::getAvailableRoles())) {
                throw new \InvalidArgumentException(sprintf('Invalid role "%s"', $roles));
            }
        }
    
        $this->roles = $roles;
    
        return $this;
    }

    public function getTelephone(): ?int
    {
        return $this->telephone;
    }

    public function setTelephone(int $telephone): self
    {
        $this->telephone = $telephone;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    public function getDatenaiss(): ?\DateTimeInterface
    {
        return $this->datenaiss;
    }

    public function setDatenaiss(\DateTimeInterface $datenaiss): self
    {
        $this->datenaiss = $datenaiss;

        return $this;
    }
    public function getUsername(): ?string
    {
        return $this->email;
    }



    public function getSalt(): ?string
    {
        // you do not need to use a salt with modern password hashing
        // see https://auth0.com/blog/adding-salt-to-hashing-a-better-way-to-store-passwords/
        return null;
    }

    public function eraseCredentials(): void
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }
    public function getUserIdentifier(): string
{
    return (string) $this->email;
}

    public function isVerified(): bool
    {
        return $this->isVerified;
    }

    public function setIsVerified(bool $isVerified): self
    {
        $this->isVerified = $isVerified;

        return $this;
    }

    public function __toString(): string
    {
        return sprintf("Email: %s\nRoles: %s\nPassword: %s\nVerified: %s\nNom: %s\nPrenom:  %s\nTelephone: %s\n",
            $this->email,
            implode(',', $this->roles),
            $this->password,
            $this->isVerified ? 'true' : 'false',
            $this->nom,
            $this->prenom,
            
            $this->telephone
        );
    }

    public function getImg(): ?string
    {
        return $this->img;
    }

    public function setImg(?string $img): self
    {
        $this->img = $img;

        return $this;
    } 
    public function setImgFile(?File $imgFile = null): void
    {
        $this->imgFile = $imgFile;

    }

    public function getImgFile(): ?File
    {
        return $this->imgFile;
    }


}

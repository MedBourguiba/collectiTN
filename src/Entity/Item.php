<?php

namespace App\Entity;

use App\Repository\ItemRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\Serializer\Annotation\Groups;
use Vich\UploaderBundle\Mapping\Annotation as Vich;

#[ORM\Entity(repositoryClass: ItemRepository::class)]
#[Vich\Uploadable]

class Item
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['Items'])]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Groups(['Items'])]
    private ?string $name = null;

    #[ORM\Column(length: 255)]
    #[Groups(['Items'])]
    private ?string $description = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    #[Groups(['Items'])]
    private ?\DateTimeInterface $start_time = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    #[Groups(['Items'])]
    private ?\DateTimeInterface $end_time = null;

    #[ORM\Column]
    #[Groups(['Items'])]
    private ?float $starting_price = null;

    #[ORM\Column]
    #[Groups(['Items'])]
    private ?float $estimated_price = null;
    

    #[ORM\Column(type: Types::SMALLINT)]
    #[Groups(['Items'])]
    private ?int $status = null;

    #[ORM\Column(length: 255)]
    private ?string $img = null;

    #[Vich\UploadableField(mapping: 'item_image', fileNameProperty: 'img')]
    private ?File $imgFile = null;

  

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    private ?Category $Category = null;

    #[ORM\OneToMany(mappedBy: 'item', targetEntity: Bids::class)]
    private Collection $bids;

    #[ORM\OneToOne(cascade: ['persist', 'remove'])]
    #[ORM\JoinColumn(nullable: false)]
    private ?Utilisateur $Partner = null;

    #[ORM\OneToOne(cascade: ['persist', 'remove'])]
    private ?Utilisateur $winner = null;

    public function __construct()
    {
        $this->bids = new ArrayCollection();
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

    public function getStartTime(): ?\DateTimeInterface
    {
        return $this->start_time;
    }

    public function setStartTime(\DateTimeInterface $start_time): self
    {
        $this->start_time = $start_time;

        return $this;
    }

    public function getEndTime(): ?\DateTimeInterface
    {
        return $this->end_time;
    }

    public function setEndTime(\DateTimeInterface $end_time): self
    {
        $this->end_time = $end_time;

        return $this;
    }

    public function getStartingPrice(): ?float
    {
        return $this->starting_price;
    }

    public function setStartingPrice(float $starting_price): self
    {
        $this->starting_price = $starting_price;

        return $this;
    }

    public function getEstimatedPrice(): ?float
    {
        return $this->estimated_price;
    }

    public function setEstimatedPrice(float $estimated_price): self
    {
        $this->estimated_price = $estimated_price;

        return $this;
    }

    public function getStatus(): int
    {
        return $this->status;
    }

    public function setStatus(int $status): self
    {
        $this->status = $status;

        return $this;
    } 

    

    public function getImg(): ?string
    {
        return $this->img ;
    }

    public function setImg(string $img): self
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

    public function getCategory(): ?Category
    {
        return $this->Category;
    }

    public function setCategory(?Category $Category): self
    {
        $this->Category = $Category;

        return $this;
    }

    /**
     * @return Collection<int, Bids>
     */
    public function getBids(): Collection
    {
        return $this->bids;
    }

    public function addBid(Bids $bid): self
    {
        if (!$this->bids->contains($bid)) {
            $this->bids->add($bid);
            $bid->setItem($this);
        }

        return $this;
    }

    public function removeBid(Bids $bid): self
    {
        if ($this->bids->removeElement($bid)) {
            // set the owning side to null (unless already changed)
            if ($bid->getItem() === $this) {
                $bid->setItem(null);
            }
        }

        return $this;
    }

    public function getPartner(): ?Utilisateur
    {
        return $this->Partner;
    }

    public function setPartner(Utilisateur $Partner): self
    {
        $this->Partner = $Partner;

        return $this;
    }

    public function getWinner(): ?Utilisateur
    {
        return $this->winner;
    }

    public function setWinner(?Utilisateur $winner): self
    {
        $this->winner = $winner;

        return $this;
    }
}

<?php

namespace App\Entity;

use App\Repository\WatchlistRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: WatchlistRepository::class)]
class Watchlist
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\OneToOne(cascade: ['persist', 'remove'])]
    private ?Utilisateur $user_id = null;

    #[ORM\OneToMany(mappedBy: 'watchlist', targetEntity: Item::class)]
    private Collection $item_id;

    public function __construct()
    {
        $this->item_id = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUserId(): ?Utilisateur
    {
        return $this->user_id;
    }

    public function setUserId(?Utilisateur $user_id): self
    {
        $this->user_id = $user_id;

        return $this;
    }

    /**
     * @return Collection<int, Item>
     */
    public function getItemId(): Collection
    {
        return $this->item_id;
    }

    public function addItemId(Item $itemId): self
    {
        if (!$this->item_id->contains($itemId)) {
            $this->item_id->add($itemId);
            $itemId->setWatchlist($this);
        }

        return $this;
    }

    public function removeItemId(Item $itemId): self
    {
        if ($this->item_id->removeElement($itemId)) {
            // set the owning side to null (unless already changed)
            if ($itemId->getWatchlist() === $this) {
                $itemId->setWatchlist(null);
            }
        }

        return $this;
    }
}

<?php

namespace App\Entity;

use App\Repository\OffreRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=OffreRepository::class)
 */
class Offre
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="float")
     */
    private $montant;

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    private $promotion;

    /**
     * @ORM\Column(type="datetime_immutable")
     */
    private $createdAt;

    /**
     * @ORM\OneToMany(targetEntity=TypeOffre::class, mappedBy="offre", orphanRemoval=true)
     */
    private $typeOffres;

    public function __construct()
    {
        $this->typeOffres = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getMontant(): ?float
    {
        return $this->montant;
    }

    public function setMontant(float $montant): self
    {
        $this->montant = $montant;

        return $this;
    }

    public function getPromotion(): ?float
    {
        return $this->promotion;
    }

    public function setPromotion(?float $promotion): self
    {
        $this->promotion = $promotion;

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

    /**
     * @return Collection|TypeOffre[]
     */
    public function getTypeOffres(): Collection
    {
        return $this->typeOffres;
    }

    public function addTypeOffre(TypeOffre $typeOffre): self
    {
        if (!$this->typeOffres->contains($typeOffre)) {
            $this->typeOffres[] = $typeOffre;
            $typeOffre->setOffre($this);
        }

        return $this;
    }

    public function removeTypeOffre(TypeOffre $typeOffre): self
    {
        if ($this->typeOffres->removeElement($typeOffre)) {
            // set the owning side to null (unless already changed)
            if ($typeOffre->getOffre() === $this) {
                $typeOffre->setOffre(null);
            }
        }

        return $this;
    }
}

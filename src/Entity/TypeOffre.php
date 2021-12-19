<?php

namespace App\Entity;

use App\Repository\TypeOffreRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=TypeOffreRepository::class)
 * @ORM\Table(name="typeOffre")
 * @ORM\InheritanceType("JOINED")
 * @ORM\DiscriminatorColumn(name="discr", type="string")
 * @ORM\DiscriminatorMap({"acheter" = "Acheter", "louer" = "Louer"})
 */
class TypeOffre
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\OneToMany(targetEntity=Voiture::class, mappedBy="typeOffre")
     */
    private $voitures;

    /**
     * @ORM\ManyToOne(targetEntity=Offre::class, inversedBy="typeOffres")
     * @ORM\JoinColumn(nullable=false)
     */
    private $offre;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $isValid=false;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $ajoutInPanier=false;

    public function __construct()
    {
        $this->voitures = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return Collection|Voiture[]
     */
    public function getVoitures(): Collection
    {
        return $this->voitures;
    }

    public function addVoiture(Voiture $voiture): self
    {
        if (!$this->voitures->contains($voiture)) {
            $this->voitures[] = $voiture;
            $voiture->setTypeOffre($this);
        }

        return $this;
    }

    public function removeVoiture(Voiture $voiture): self
    {
        if ($this->voitures->removeElement($voiture)) {
            // set the owning side to null (unless already changed)
            if ($voiture->getTypeOffre() === $this) {
                $voiture->setTypeOffre(null);
            }
        }

        return $this;
    }

    public function getOffre(): ?Offre
    {
        return $this->offre;
    }

    public function setOffre(?Offre $offre): self
    {
        $this->offre = $offre;

        return $this;
    }

    public function getIsValid(): ?bool
    {
        return $this->isValid;
    }

    public function setIsValid(?bool $isValid): self
    {
        $this->isValid = $isValid;

        return $this;
    }

    public function getAjoutInPanier(): ?bool
    {
        return $this->ajoutInPanier;
    }

    public function setAjoutInPanier(?bool $ajoutInPanier): self
    {
        $this->ajoutInPanier = $ajoutInPanier;

        return $this;
    }
}

<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\MetierRepository")
 */
class Metier
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank(message="Ce champ ne peut être vide.")
     */
    private $libelle;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Employe", mappedBy="metier")
     */
    private $metier;

    public function __construct()
    {
        $this->metier = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLibelle(): ?string
    {
        return $this->libelle;
    }

    public function setLibelle(string $libelle): self
    {
        $this->libelle = $libelle;

        return $this;
    }

    /**
     * @return Collection|Employe[]
     */
    public function getMetier(): Collection
    {
        return $this->metier;
    }

    public function addMetier(Employe $metier): self
    {
        if (!$this->metier->contains($metier)) {
            $this->metier[] = $metier;
            $metier->setMetier($this);
        }

        return $this;
    }

    public function removeMetier(Employe $metier): self
    {
        if ($this->metier->contains($metier)) {
            $this->metier->removeElement($metier);
            // set the owning side to null (unless already changed)
            if ($metier->getMetier() === $this) {
                $metier->setMetier(null);
            }
        }

        return $this;
    }
}

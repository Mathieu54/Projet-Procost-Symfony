<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ProjetRepository")
 */
class Projet
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
    private $nom;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank(message="Ce champ ne peut être vide.")
     */
    private $description;

    /**
     * @ORM\Column(type="float")
     * @Assert\NotBlank(message="Ce champ ne peut être vide.")
     */
    private $prix_vente;

    /**
     * @ORM\Column(type="date")
     * @Assert\NotBlank(message="Ce champ ne peut être vide.")
     */
    private $date_creation;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $date_livraison;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Production", mappedBy="projet_id")
     */
    private $productions;

    public function __construct()
    {
        $this->productions = new ArrayCollection();
    }


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

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getPrixVente(): ?float
    {
        return $this->prix_vente;
    }

    public function setPrixVente(float $prix_vente): self
    {
        $this->prix_vente = $prix_vente;

        return $this;
    }

    public function getDateCreation(): ?\DateTimeInterface
    {
        return $this->date_creation;
    }

    public function setDateCreation(\DateTimeInterface $date_creation): self
    {
        $this->date_creation = $date_creation;

        return $this;
    }

    public function getDateLivraison(): ?\DateTimeInterface
    {
        return $this->date_livraison;
    }

    public function setDateLivraison(?\DateTimeInterface $date_livraison): self
    {
        $this->date_livraison = $date_livraison;

        return $this;
    }

    /**
     * @return Collection|Production[]
     */
    public function getProductions(): Collection
    {
        return $this->productions;
    }

    public function addProduction(Production $production): self
    {
        if (!$this->productions->contains($production)) {
            $this->productions[] = $production;
            $production->addProjetId($this);
        }

        return $this;
    }

    public function removeProduction(Production $production): self
    {
        if ($this->productions->contains($production)) {
            $this->productions->removeElement($production);
            $production->removeProjetId($this);
        }

        return $this;
    }

}

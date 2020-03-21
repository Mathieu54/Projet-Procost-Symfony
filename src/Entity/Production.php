<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ProductionRepository")
 */
class Production
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="integer")
     */
    private $time_production;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Employe", inversedBy="productions")
     */
    private $employe_id;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Projet", inversedBy="productions")
     */
    private $projet_id;

    /**
     * @ORM\Column(type="date")
     */
    private $date_ajout;

    public function __construct()
    {
        $this->employe_id = new ArrayCollection();
        $this->projet_id = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTimeProduction(): ?float
    {
        return $this->time_production;
    }

    public function setTimeProduction(float $time_production): self
    {
        $this->time_production = $time_production;

        return $this;
    }

    /**
     * @return Collection|Employe[]
     */
    public function getEmployeId(): Collection
    {
        return $this->employe_id;
    }

    public function addEmployeId(Employe $employeId): self
    {
        if (!$this->employe_id->contains($employeId)) {
            $this->employe_id[] = $employeId;
        }

        return $this;
    }

    public function removeEmployeId(Employe $employeId): self
    {
        if ($this->employe_id->contains($employeId)) {
            $this->employe_id->removeElement($employeId);
        }

        return $this;
    }

    /**
     * @return Collection|Projet[]
     */
    public function getProjetId(): Collection
    {
        return $this->projet_id;
    }

    public function addProjetId(Projet $projetId): self
    {
        if (!$this->projet_id->contains($projetId)) {
            $this->projet_id[] = $projetId;
        }

        return $this;
    }

    public function removeProjetId(Projet $projetId): self
    {
        if ($this->projet_id->contains($projetId)) {
            $this->projet_id->removeElement($projetId);
        }

        return $this;
    }

    public function getDateAjout(): ?\DateTimeInterface
    {
        return $this->date_ajout;
    }

    public function setDateAjout(\DateTimeInterface $date_ajout): self
    {
        $this->date_ajout = $date_ajout;

        return $this;
    }
}

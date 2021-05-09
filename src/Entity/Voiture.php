<?php

namespace App\Entity;

use App\Repository\VoitureRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=VoitureRepository::class)
 * @ORM\Table(name="Voitures")
 */
class Voiture
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @ORM\Column(type="text")
     */
    private $marque;

    public function getMarque(): ?string
    {
        return $this->marque;
    }

    public function setMarque($marque)
    {
        $this->marque = $marque;
    }

    /**
     * @ORM\Column(type="text")
     */
    private $coleur;

    public function getColeur(): ?string
    {
        return $this->coleur;
    }

    public function setColeur($coleur)
    {
        $this->coleur = $coleur;
    }

    /**
     * @ORM\Column(type="text")
     */
    private $description;

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription($description)
    {
        $this->description = $description;
    }

    /**
     * @ORM\Column(type="integer")
     */
    private $nombreDePlace;

    public function getNombreDePlace(): ?string
    {
        return $this->nombreDePlace;
    }

    public function setNombreDePlace($nombreDePlace)
    {
        $this->nombreDePlace = $nombreDePlace;
    }

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Agence", inversedBy="voitures")
     * @ORM\JoinColumn(nullable=true)
     * @Assert\NotNull
     */
    private $agence;

    public function getAgence(): ?Agence
    {
        return $this->agence;
    }

    public function setAgence(?Agence $agence): self
    {
        $this->agence = $agence;

        return $this;
    }

    /**
     * @ORM\Column(type="integer")
     */
    private $agenceId;

    public function getAgenceId() {
        return $this->agenceId;
    }

    public function setAgenceId($agenceId) {
        $this->agenceId = $agenceId;
    }
}

<?php

namespace App\Entity;

use App\Repository\AgenceRepository;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * @ORM\Entity(repositoryClass=AgenceRepository::class)
 * @ORM\Table(name="Agences")
 */
class Agence
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
     * @ORM\Column(type="text", length=60)
     */
    private $nom;

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom($nom)
    {
        $this->nom = $nom;
    }

    /**
     * @ORM\Column(type="text")
     */
    private $telAgence;

    public function getTelAgence(): ?string
    {
        return $this->telAgence;
    }

    public function setTelAgence($telAgence)
    {
        $this->telAgence = $telAgence;
    }

    /**
     * @ORM\Column(type="text", length=150)
     */
    private $addressVille;

    public function getAddressVille(): ?string
    {
        return $this->addressVille;
    }

    public function setAddressVille($addressVille)
    {
        $this->addressVille = $addressVille;
    }

    // mappedBy ---> $agence in voiture.
    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Voiture", mappedBy="agence", cascade={"persist", "remove"})
     */
    private $voitures;

    public function __construct()
    {
        $this->voitures = new ArrayCollection();
    }

    public function getVoitures()
    {
        return $this->voitures;
    }
}

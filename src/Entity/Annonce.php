<?php

namespace App\Entity;

use App\Repository\AnnonceRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: AnnonceRepository::class)]
class Annonce
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 100)]
    private ?string $typeAnnonce = null;

    #[ORM\Column(length: 255)]
    private ?string $infoAnnonce = null;

    #[ORM\Column(length: 100)]
    private ?string $prix = null;

    #[ORM\Column(length: 100)]
    private ?string $photoAnnonce = null;

/*     #[ORM\OneToMany(mappedBy: 'annonces', targetEntity: Voiture::class)]
    private Collection $voitures; */

    public function __construct()
    {
       // $this->voitures = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTypeAnnonce(): ?string
    {
        return $this->typeAnnonce;
    }

    public function setTypeAnnonce(string $typeAnnonce): self
    {
        $this->typeAnnonce = $typeAnnonce;

        return $this;
    }

    public function getInfoAnnonce(): ?string
    {
        return $this->infoAnnonce;
    }

    public function setInfoAnnonce(string $infoAnnonce): self
    {
        $this->infoAnnonce = $infoAnnonce;

        return $this;
    }

   


    public function getPrix(): ?string
    {
        return $this->prix;
    }

    public function setPrix(string $prix): self
    {
        $this->prix = $prix;

        return $this;
    }

    public function getPhotoAnnonce(): ?string
    {
        return $this->photoAnnonce;
    }

    public function setPhotoAnnonce(string $photoAnnonce): self
    {
        $this->photoAnnonce = $photoAnnonce;

        return $this;
    }

   

    
}

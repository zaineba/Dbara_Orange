<?php

namespace App\Entity;

use App\Repository\ChefRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use App\Entity\DbaraRecette;
use App\Entity\DbaraLive;

#[ORM\Entity(repositoryClass: ChefRepository::class)]
class Chef
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $nom = null;

    #[ORM\Column(length: 255)]
    private ?string $prenom = null;

    #[ORM\Column(length: 255)]
    private ?string $specialite = null;

    #[ORM\Column(length: 255)]
    private ?string $email = null;

    #[ORM\Column(length: 255)]
    private ?string $numerotelephone = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $photo = null;

    #[ORM\OneToMany(mappedBy: 'chef', targetEntity: DbaraRecette::class, cascade: ["remove"])]
    private Collection $recette;

    #[ORM\OneToMany(mappedBy: 'chef', targetEntity: DbaraReel::class, cascade: ["remove"])]
    private Collection $dbarareel;
    #[ORM\OneToMany(mappedBy: 'chef', targetEntity: DbaraLive::class, cascade: ["remove"])]
    private Collection $dbaralive;


    public function __construct()
    {
        $this->recette = new ArrayCollection();
        $this->dbarareel = new ArrayCollection();
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

    public function getPrenom(): ?string
    {
        return $this->prenom;
    }

    public function setPrenom(string $prenom): self
    {
        $this->prenom = $prenom;

        return $this;
    }

    public function getSpecialite(): ?string
    {
        return $this->specialite;
    }

    public function setSpecialite(string $specialite): self
    {
        $this->specialite = $specialite;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getNumerotelephone(): ?string
    {
        return $this->numerotelephone;
    }

    public function setNumerotelephone(string $numerotelephone): self
    {
        $this->numerotelephone = $numerotelephone;

        return $this;
    }

    public function getPhoto(): ?string
    {
        return $this->photo;
    }

    public function setPhoto(string $photo): self
    {
        $this->photo = $photo;

        return $this;
    }

    /**
     * @return Collection<int, DbaraRecette>
     */
    public function getRecette(): Collection
    {
        return $this->recette;
    }

    public function addRecette(DbaraRecette $recette): self
    {
        if (!$this->recette->contains($recette)) {
            $this->recette->add($recette);
            $recette->setChef($this);
        }

        return $this;
    }

    public function removeRecette(DbaraRecette $recette): self
    {
        if ($this->recette->removeElement($recette)) {
            // set the owning side to null (unless already changed)
            if ($recette->getChef() === $this) {
                $recette->setChef(null);
            }
        }

        return $this;
    }
    public function __toString()
    {
        return $this->nom; // Ou $this->prenom pour afficher le prénom du chef
    }

    /**
     * @return Collection<int, DbaraReel>
     */
    public function getDbarareel(): Collection
    {
        return $this->dbarareel;
    }

    public function addDbarareel(DbaraReel $dbarareel): self
    {
        if (!$this->dbarareel->contains($dbarareel)) {
            $this->dbarareel->add($dbarareel);
            $dbarareel->setChef($this);
        }

        return $this;
    }

    public function removeDbarareel(DbaraReel $dbarareel): self
    {
        if ($this->dbarareel->removeElement($dbarareel)) {
            // set the owning side to null (unless already changed)
            if ($dbarareel->getChef() === $this) {
                $dbarareel->setChef(null);
            }
        }

        return $this;
    }

    public function getDbaraLive(): Collection
    {
        return $this->dbaralive;
    }

    public function addDbaraLive(DbaraLive $dbaralive): self

    {
        if (!$this->dbaralive->contains($dbaralive)) {
            $this->dbaralive->add($dbaralive);
            $dbaralive->setChef($this);
        }

        return $this;
    }


    public function removeDbaraLive(DbaraLive $dbaraLive): self
    {
        if ($this->dbaralive->removeElement($dbaraLive)) {
            // set the owning side to null (unless already changed)
            if ($dbaraLive->getChef() === $this) {
                $dbaraLive->setChef(null);
            }
        }

        return $this;
    }
}

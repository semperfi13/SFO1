<?php

namespace App\Entity;

use App\Repository\EleveRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=EleveRepository::class)
 */
class Eleve
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $nom;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $prenom;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $age;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="eleves")
     * @ORM\JoinColumn(nullable=false)
     */
    private $parent;

    /**
     * @ORM\OneToMany(targetEntity=Note::class, mappedBy="eleve")
     */
    private $notes;

    /**
     * @ORM\OneToMany(targetEntity=Absence::class, mappedBy="eleve")
     */
    private $absences;

    /**
     * @ORM\OneToMany(targetEntity=Retard::class, mappedBy="eleve")
     */
    private $retard;

    /**
     * @ORM\ManyToOne(targetEntity=Classe::class, inversedBy="eleves")
     * @ORM\JoinColumn(nullable=false)
     */
    private $classe;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $Matricule;


    public function __toString()
    {
        return $this->notes;
    }



    public function __construct()
    {
        $this->notes = new ArrayCollection();
        $this->absences = new ArrayCollection();
        $this->retard = new ArrayCollection();
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

    public function getAge(): ?string
    {
        return $this->age;
    }

    public function setAge(string $age): self
    {
        $this->age = $age;

        return $this;
    }

    public function getParent(): ?User
    {
        return $this->parent;
    }

    public function setParent(?User $parent): self
    {
        $this->parent = $parent;

        return $this;
    }

    /**
     * @return Collection<int, Note>
     */
    public function getNotes(): Collection
    {
        return $this->notes;
    }

    public function addNote(Note $note): self
    {
        if (!$this->notes->contains($note)) {
            $this->notes[] = $note;
            $note->setEleve($this);
        }

        return $this;
    }

    public function removeNote(Note $note): self
    {
        if ($this->notes->removeElement($note)) {
            // set the owning side to null (unless already changed)
            if ($note->getEleve() === $this) {
                $note->setEleve(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Absence>
     */
    public function getAbsences(): Collection
    {
        return $this->absences;
    }

    public function addAbsence(Absence $absence): self
    {
        if (!$this->absences->contains($absence)) {
            $this->absences[] = $absence;
            $absence->setEleve($this);
        }

        return $this;
    }

    public function removeAbsence(Absence $absence): self
    {
        if ($this->absences->removeElement($absence)) {
            // set the owning side to null (unless already changed)
            if ($absence->getEleve() === $this) {
                $absence->setEleve(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Retard>
     */
    public function getRetard(): Collection
    {
        return $this->retard;
    }

    public function addRetard(Retard $retard): self
    {
        if (!$this->retard->contains($retard)) {
            $this->retard[] = $retard;
            $retard->setEleve($this);
        }

        return $this;
    }

    public function removeRetard(Retard $retard): self
    {
        if ($this->retard->removeElement($retard)) {
            // set the owning side to null (unless already changed)
            if ($retard->getEleve() === $this) {
                $retard->setEleve(null);
            }
        }

        return $this;
    }

    public function getClasse(): ?Classe
    {
        return $this->classe;
    }

    public function setClasse(?Classe $classe): self
    {
        $this->classe = $classe;

        return $this;
    }

    public function getMatricule(): ?string
    {
        return $this->Matricule;
    }

    public function setMatricule(?string $Matricule): self
    {
        $this->Matricule = $Matricule;

        return $this;
    }
}

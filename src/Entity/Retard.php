<?php

namespace App\Entity;

use App\Repository\RetardRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=RetardRepository::class)
 */
class Retard
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="datetime")
     */
    private $dateretard;

    /**
     * @ORM\ManyToOne(targetEntity=Eleve::class, inversedBy="retard")
     */
    private $eleve;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDateretard(): ?\DateTimeInterface
    {
        return $this->dateretard;
    }

    public function setDateretard(\DateTimeInterface $dateretard): self
    {
        $this->dateretard = $dateretard;

        return $this;
    }

    public function getEleve(): ?Eleve
    {
        return $this->eleve;
    }

    public function setEleve(?Eleve $eleve): self
    {
        $this->eleve = $eleve;

        return $this;
    }
}

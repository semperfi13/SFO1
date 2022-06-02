<?php

namespace App\Entity;

use App\Repository\HistoriqueconnexionRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=HistoriqueconnexionRepository::class)
 */
class Historiqueconnexion
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
    private $dateconnexion;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $email;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $ip;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $Url;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDateconnexion(): ?\DateTimeInterface
    {
        return $this->dateconnexion;
    }

    public function setDateconnexion(\DateTimeInterface $dateconnexion): self
    {
        $this->dateconnexion = $dateconnexion;

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

    public function getIp(): ?string
    {
        return $this->ip;
    }

    public function setIp(string $ip): self
    {
        $this->ip = $ip;

        return $this;
    }

    public function getUrl(): ?string
    {
        return $this->Url;
    }

    public function setUrl(?string $Url): self
    {
        $this->Url = $Url;

        return $this;
    }
}

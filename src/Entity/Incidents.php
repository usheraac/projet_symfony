<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\IncidentsRepository")
 */
class Incidents
{

    /**
     * @ORM\ManyToOne(targetEntity="projet-web\src\Entity\Employes")
     * @ORM\JoinColumn(nullable=false)
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $objet;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $description;

    /**
     * @ORM\Column(type="string", length=50)
     */
        private $service;

    /**
     * @ORM\Column(type="datetime")
     */
    private $date;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $dateTarget;

    /**
     * @ORM\Column(type="string", length=50, nullable=true)
     */

    private $status;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $discussion;

    /**
     * @ORM\Column(type="string", length=50, nullable=false)
     */
    private $employe;
    

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getObjet(): ?string
    {
        return $this->objet;
    }

    public function setObjet(string $objet): self
    {
        $this->objet = $objet;

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

    public function getService(): ?string
    {
        return $this->service;
    }

    public function setService(string $service): self
    {
        $this->service = $service;

        return $this;
    }

    public function getDate(): ?\DateTimeInterface
    {
        return $this-> date;
    }

    public function setDate(\DateTimeInterface $date): self
    {
        $this->date = $date;

        return $this;
    }

    public function getDateTarget(): ?\DateTimeInterface
    {
        return $this->dateTarget;
    }

    public function setDateTarget(?\DateTimeInterface $dateTarget): self
    {
        $this->dateTarget = $dateTarget;

        return $this;
    }

    public function getStatus(): ?string
    {
        return $this->status;
    }

    public function setStatus(?string $status): self
    {
        $this->status = $status;

        return $this;
    }

    public function getDiscussion(): ?string
    {
        return $this->discussion;
    }

    public function setDiscussion(?string $discussion): self
    {
        $this->discussion = $discussion;

        return $this;
    }

    public function getEmploye(): ?string
    {
        return $this->employe;
    }

    public function setEmploye(string $employe): self
    {
        $this->employe = $employe;

        return $this;
    }
}

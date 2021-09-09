<?php

namespace App\Entity;

use App\Repository\PharmacieRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=PharmacieRepository::class)
 */
class Pharmacie
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Groups("pharma")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups("pharma")
     * @Assert\NotBlank(message="le nom est obligatoire")
     */
    private $nom;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups("pharma")
     * @Assert\NotBlank(message="le quartier est obligatoire")
     */
    private $quartier;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups("pharma")
     * @Assert\NotBlank(message="la ville est obligatoire")
     */
    private $ville;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups("pharma")
     * @Assert\NotBlank(message="les jours de garde sont obligatoires")
     */
    private $garde;

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

    public function getQuartier(): ?string
    {
        return $this->quartier;
    }

    public function setQuartier(string $quartier): self
    {
        $this->quartier = $quartier;

        return $this;
    }

    public function getVille(): ?string
    {
        return $this->ville;
    }

    public function setVille(string $ville): self
    {
        $this->ville = $ville;

        return $this;
    }

    public function getGarde(): ?string
    {
        return $this->garde;
    }

    public function setGarde(string $garde): self
    {
        $this->garde = $garde;

        return $this;
    }
}

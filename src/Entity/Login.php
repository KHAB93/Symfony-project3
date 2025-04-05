<?php

namespace App\Form;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity()
 */
class Login
{
    /**
     * @ORM\Column(type="string")
     */
    private $nomutilisateur;

    /**
     * @ORM\Column(type="string")
     */
    private $motdepasse;

    public function getNomutilisateur(): ?string
    {
        return $this->nomutilisateur;
    }

    public function getMotdepasse(): ?string
    {
        return $this->motdepasse;
    }

    public function setNomutilisateur(string $nomutilisateur): self
    {
        $this->nomutilisateur = $nomutilisateur;
        return $this;
    }

    public function setMotdepasse(string $motdepasse): self
    {
        $this->motdepasse = $motdepasse;
        return $this;
    }
}
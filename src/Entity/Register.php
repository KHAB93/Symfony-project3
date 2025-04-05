<?php
namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity()
 */
class Register
{
    /**
     * @ORM\Column(type="string")
     */
    private $name;

    public function getName(): ?string
    {
        return $this->name;
    }

    private $email;

    public function getEmail(): ?string
    {
        return $this->email;
    }
    
    private $adressedelivraison;

    public function getAdressedelivraison(): ?string
    {
        return $this->adressedelivraison;
    }

    private $motdepasse;

    public function getMotdepasse(): ?string
    {
        return $this->motdepasse;
    }

    private $confirmerlemotdepasse;

    public function getConfirmerlemotdepasse(): ?string
    {
        return $this->confirmerlemotdepasse;
    }

}
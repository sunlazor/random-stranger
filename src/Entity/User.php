<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="App\Repository\UserRepository")
 */
class User
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @Assert\NotNull()
     * @Assert\NotBlank()
     * @Assert\Length(
     *     min = 4,
     *     max = 60
     * )
     * @Assert\Regex("/^[a-z0-9]+[a-z0-9_-]*$/iU")
     * Проверка: https://regex101.com/r/BVXYe6/2
     *
     * @ORM\Column(type="string", length=64)
     */
    private $login;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $password;

    /**
     * @ORM\Column(type="integer")
     */
    private $chatWas;

    public function __construct()
    {
        $this->chatWas = 0;
    }

    public function expose() :array
    {
        return get_object_vars($this);
    }

    public function getId()
    {
        return $this->id;
    }

    public function getLogin(): ?string
    {
        return $this->login;
    }

    public function setLogin(string $login): self
    {
        $this->login = $login;

        return $this;
    }

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    public function getChatWas(): ?int
    {
        return $this->chatWas;
    }

    public function setChatWas(int $chatWas): self
    {
        $this->chatWas = $chatWas;

        return $this;
    }
}

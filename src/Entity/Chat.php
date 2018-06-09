<?php

namespace App\Entity;

use App\Utils;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ChatRepository")
 */
class Chat
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=16)
     */
    private $code;

    public function __construct()
    {
        $this->code = Utils::generateRandomString();
    }

    public function getId()
    {
        return $this->id;
    }

    public function getCode(): ?string
    {
        return $this->code;
    }

    private function setCode(string $code): self
    {
        $this->code = $code;

        return $this;
    }
}

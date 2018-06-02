<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ChatUserRepository")
 */
class ChatUser
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="integer")
     */
    private $chat_id;

    /**
     * @ORM\Column(type="integer")
     */
    private $user_id;

    public function getId()
    {
        return $this->id;
    }

    public function getChatId(): ?int
    {
        return $this->chat_id;
    }

    public function setChatId(int $chat_id): self
    {
        $this->chat_id = $chat_id;

        return $this;
    }

    public function getUserId(): ?int
    {
        return $this->user_id;
    }

    public function setUserId(int $user_id): self
    {
        $this->user_id = $user_id;

        return $this;
    }
}

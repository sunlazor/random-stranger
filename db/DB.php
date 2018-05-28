<?php
/**
 * Created by PhpStorm.
 * User: sunlazor
 * Date: 05.05.18
 * Time: 0:06
 */

namespace App;
use PDO;

final class DB
{
    //$dsn = "<driver>://<username>:<password>@<host>:<port>/<database>";
    private $dsn;

    private $pdo;

    public function __construct($dsn = "sqlite:./db//db.sqlite")
    {
        $this->dsn = $dsn;
        $this->pdo = new PDO($dsn);
    }

    public function getUsers()
    {
        $stmt = $this->pdo->query('SELECT id, login FROM users;');
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function addNewUser($login)
    {
        $stmt = $this->pdo->prepare('INSERT INTO users(login) VALUES (:login);');
        $stmt->bindParam(':login', $login);
        $stmt->execute();
//        $stmt->execute(array(":login" => $login));
    }

    public function addChat($title)
    {
        $stmt = $this->pdo->prepare('INSERT INTO chats(title) VALUES (:title);');
        if($title === '') {
            $title = 'NO TITLE';
        }
        $stmt->bindParam(':title', $title);
        $stmt->execute();
    }

    public function getChats()
    {
        $stmt = $this->pdo->query('SELECT id, title FROM chats;');
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function readChat($id)
    {
        $stmt = $this->pdo->prepare('SELECT date, sender_user_id, content FROM messages WHERE target_chat_id = :id LIMIT 100;');
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
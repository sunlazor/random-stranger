<?php
/**
 * Created by PhpStorm.
 * User: sunlazor
 * Date: 04.05.18
 * Time: 23:53
 */

namespace App;


class User
{
    protected $id;

    protected $login;

    public  function __construct($login)
    {
        $this->login = $login;
        $id = NULL;
    }
}
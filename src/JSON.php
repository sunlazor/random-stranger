<?php
/**
 * Created by PhpStorm.
 * User: sunlazor
 * Date: 09.05.18
 * Time: 22:03
 */

namespace App;
//use PDO;

class JSON
{
    public static function getChatsList($chatsList)
    {
//        $chats = $chatsList->fetchAll(\PDO::FETCH_ASSOC);
        $json = json_encode($chatsList);
        //
        echo $json;
    }
}
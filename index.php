<?php
/**
 * Created by PhpStorm.
 * User: sunlazor
 * Date: 04.05.18
 * Time: 2:51
 */

require ('vendor/autoload.php');
use App\DB;

require ('config/init.php');

$aDB = new DB();

require ('router.php');

$title = "Nice day?";

if(!$apiRoute) {
    $users = $aDB->getUsers();
    $chats = $aDB->getChats();
    $firstChat = $aDB->readChat(1);

    include('view/head.html');
    include('view/body.html');
    include('view/foot.html');
}

?>
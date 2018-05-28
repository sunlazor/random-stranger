<?php
/**
 * Created by PhpStorm.
 * User: sunlazor
 * Date: 04.05.18
 * Time: 23:23
 * Стыдно за эту портянку
 */

require ('vendor/autoload.php');
use App\JSON;

// API route or web
$apiRoute = false;
if (strpos(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH), $API_STR))
{
    $apiRoute = true;
}

if ($apiRoute) {
//user registration
    if (isExactRoute('/v0/users') && isPost()) {
        $aDB->addNewUser($_REQUEST['login']);
    }

//chat creation
    if (isExactRoute('/v0/chats') && isPost()) {
//        $aDB->addChat($_REQUEST['title']);
//        $aDB->getChats();
        JSON::getChatsList($aDB->getChats());
    }

//chat read
    if (isExactRoute('/v0/chats') && isParamExists('id') && isPost()) {
        $aDB->readChat($_REQUEST['id']);
    }
}

function isGet()
{
    return 'GET' === $_SERVER['REQUEST_METHOD'];
}

function isPost()
{
    return 'POST' === $_SERVER['REQUEST_METHOD'];
}

function isExactRoute($route)
{

    return trim(
        parse_url(
            $_SERVER['REQUEST_URI'], PHP_URL_PATH
        ),  '/'

    ) === trim($route, '/');
}

function isParamExists($paramName)
{
    return isset($_REQUEST[$paramName]);
}

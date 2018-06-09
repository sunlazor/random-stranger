<?php

namespace App;

use App\Entity\Chat;
use Doctrine\Bundle\DoctrineBundle\DoctrineBundle;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class Utils
{
    public static function generateRandomString($length = 16): string
    {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = \strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[random_int(0, $charactersLength - 1)];
        }
        return $randomString;
    }

    public static function getRequestJSONArray(Request $request)
    {
        // Чтение JSON из запроса и преобразование в массив
        return json_decode($request->getContent(), true);
    }

    /**
     * @param Request $request Объект запроса из которого берется тело с аргументами
     * @param array $params Массив значений, которые надо проверить
     * @return bool|array Возвращает true если все параметры присутствуют или массив отсутсвующих
     */
    public static function isAllJSONParamsExists(Request $request, array $params)
    {
        $json = json_decode($request->getContent(), true);
        if ($json === null) {
            return $params;
        }
        $result = [];
        foreach ($params as $param)
        {
            if (!array_key_exists($param, $json))
            {
                $result[] = $param;
            }
        }
        if(\count($result) === 0) {
            $result = true;
        }
        return $result;
    }
}
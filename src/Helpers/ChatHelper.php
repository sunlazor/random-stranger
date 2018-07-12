<?php
/**
 * Created by PhpStorm.
 * User: sunlazor
 * Date: 09.07.18
 * Time: 17:47
 */

namespace App\Helpers;


use App\Entity\Chat;
use App\Utils;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;

final class ChatHelper
{

    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * Проверка наличия данного чата в БД
     * Проверка идет только по id
     * TODO: Сделать проверку и по коду
     *
     * @param Chat $chat Объект с пользователем для проверки
     * @return bool Возвращает true если пользователь найден. false если нет или дан пустой объект
     */
    public function isChatExists(Chat $chat): bool
    {
        if (null === $chat) {
            return false;
        }
        $findArgs = [];
        if (null !== $chat->getId()) {
            $findArgs['id'] = $chat->getId();
        }
        else {
            return false;
        }
//        $findArgs['login'] = $chat->getLogin();
        $found = $this->entityManager->getRepository(Chat::class)->findOneBy($findArgs);
        return !($found === null);
    }

    /**
     * Сбор полей из запроса для записи класса Chat
     *
     * @param Request $request Объект запроса
     * TODO: В будущем необходимо собирать сразу весь класс(?)
     * @return string Полученный из запроса ID чата
     */
    public function extractChat(Request $request)
    {
        // Чтение JSON из запроса
        $json = Utils::getRequestJSONArray($request);
        // Создание и заполнение данными нового пользователя
        $chatID = htmlspecialchars($json['id']);

        return $chatID;
    }

}
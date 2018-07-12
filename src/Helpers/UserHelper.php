<?php
/**
 * Created by PhpStorm.
 * User: sunlazor
 * Date: 09.06.18
 * Time: 18:12
 */

namespace App\Helpers;


use App\Entity\User;
use App\Utils;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;

class UserHelper
{
    protected $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * Проверка наличия данного пользователя в БД
     * Проверка идет только по login и id (если есть)
     *
     * @param User $user Объект с пользователем для проверки
     * @return bool Возвращает true если пользователь найден. false если нет или дан пустой объект
     */
    public function isUserExists(User $user): bool
    {
        if (null === $user) {
            return false;
        }
        $findArgs = [];
        if (null !== $user->getId()) {
            $findArgs['id'] = $user->getId();
        }
        $findArgs['login'] = $user->getLogin();
        $found = $this->entityManager->getRepository(User::class)->findOneBy($findArgs);
        return !($found === null);
    }

    /**
     * Сбор полей из запроса для записи класса User
     *
     * @param Request $request Объект запроса
     * TODO: В будущем необходимо собирать сразу весь класс(?)
     * @return string Полученный из запроса логин
     */
    public function extractUser(Request $request)
    {
        // Чтение JSON из запроса
        $json = Utils::getRequestJSONArray($request);
        // Создание и заполнение данными нового пользователя
        $login = htmlspecialchars($json['login']);

        return $login;
    }

}
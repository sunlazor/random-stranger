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
     * Проверка идет только по login
     *
     * @param User $user Объект с пользователем для проверки
     * @return bool Возвращает true если пользователь найден. false если нет или дан пустой объект
     */
    public function isUserExists(User $user): bool
    {
        // TODO: добавить запись события в логи
        if (null === $user) {
            return false;
        }
        $findArgs = [];
//        if (null !== $user->getId()) {
//            $findArgs['id'] = $user->getId();
//        }
        $findArgs['login'] = $user->getLogin();
        $found = $this->entityManager->getRepository(User::class)->findOneBy($findArgs);
        return !($found === null);
    }

    /**
     * Сбор полей логина и пароля из запроса для записи класса User
     *
     * @param Request $request Объект запроса
     * @return User Полученный из запроса логин
     */
    public function extractUser(Request $request): User
    {
        // Чтение JSON из запроса
        $json = Utils::getRequestJSONArray($request);
        // Создание и заполнение данными нового пользователя
        $user = new User();
        $user->setLogin(htmlspecialchars($json['login']));
        $user->setPassword(htmlspecialchars($json['password']));

        return $user;
    }

}
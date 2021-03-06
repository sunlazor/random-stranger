<?php

namespace App\Controller;

use App\Entity\User;
use App\Entity\ChatUser;
use App\Entity\Chat;
use App\Helpers\ChatHelper;
use App\Helpers\UserHelper;
use App\Utils;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

final class ChatController extends Controller
{
//    /**
//     * @Route("/chat", name="chat")
//     */
//    public function index()
//    {
//        return $this->render('chat/index.html.twig', [
//            'controller_name' => 'ChatController',
//        ]);
//    }

    private $userHelper;
    private $chatHelper;

    public function __construct(UserHelper $userHelper, ChatHelper $chatHelper)
    {
        $this->userHelper = $userHelper;
        $this->chatHelper = $chatHelper;
    }

    /**
     * @Route(
     *     "/chat/create",
     *     methods={"POST"}
     * )
     *
     * @param Request $request Объект запроса
     *
     * @return JsonResponse
     * @throws \Exception
     */
    public function createChat(Request $request): JsonResponse
    {
        // Проверка наличия всех необходимых параметров
        $allParams = Utils::isAllJSONParamsExists($request, ['login', 'password']);
        if ($allParams !== true)
        {
            $errorsMsg = ['Error' => 'No enough params', 'Lost' => implode(', ', $allParams)];
            // Ответ клиенту
            return new JsonResponse($errorsMsg, Response::HTTP_UNAUTHORIZED);
        }
        // Чтение JSON из запроса
        $json = Utils::getRequestJSONArray($request);
        // Верификация пользователя из запроса
        $user = $this->getDoctrine()
            ->getRepository(User::class)->findOneBy(['login' => $json['login']]);
        // Проверка наличия пользователя
        if (null === $user)
        {
            $errorsMsg = ['Unknown user' => $json['login']];
            // Ответ клиенту
            return new JsonResponse($errorsMsg, Response::HTTP_UNAUTHORIZED);
        }
        // Проверка пароля
        if ($user->getPassword() !== $json['password'])
        {
            $errorsMsg = ['Error' => 'Wrong password'];
            // Ответ клиенту
            return new JsonResponse($errorsMsg, Response::HTTP_UNAUTHORIZED);
        }
        // Создание чата
        // Работа с БД
        $entityManager = $this->getDoctrine()->getManager();
        // Запись нового чата БД
        $chat = new Chat();
        $entityManager->persist($chat);
        $entityManager->flush();
        // Добавление пользователя в чат
        $chatUser = new ChatUser();
        $chatUser->setChatId($chat->getId());
        $chatUser->setUserId($user->getId());
        $entityManager->persist($chatUser);
        $entityManager->flush();

        return new JsonResponse(['Chat' => $chat->getCode()], Response::HTTP_OK);
    }


    /**
     * @Route(
     *     "/chat/{chatId}/addUser/{userLogin}",
     *     methods={"POST"}
     * )
     */
    public function addChatUser($chatId, $userLogin)//Request $request)
    {
        $user = new User();
//        $user->setLogin($this->userHelper->extractUser($request));
        $user->setLogin($userLogin);
        $chat = new Chat();
//        $chat->setId($this->chatHelper->extractChat($request));
        $chat->setId($chatId);
        $this->addChatUserObj($chat, $user);
        return new JsonResponse(['User added' => 'Ok'], Response::HTTP_OK);
    }


    public function addChatUserObj(Chat $chat, User $user)
    {
        if ($this->chatHelper->isChatExists($chat) && $this->userHelper->isUserExists($user))
        {
            // Работа с БД
            $entityManager = $this->getDoctrine()->getManager();

            $chatUser = new ChatUser();
            // TODO: убрать
            $user->setId(4);
            // Добавление пользователя в чат
            $chatUser->setChatId($chat->getId());
            $chatUser->setUserId($user->getId());
            $entityManager->persist($chatUser);
            $entityManager->flush();
        }
    }

    /**
     * Проверка наличия данного чата в БД
     * Проверка идет только по id
     * TODO: Сделать проверку и по коду
     *
     * @param Chat $chat Объект с пользователем для проверки
     * @return bool Возвращает true если пользователь найден. false если нет или дан пустой объект
     */
//    public function isChatExists(Chat $chat): bool
//    {
//        if (null === $chat) {
//            return false;
//        }
//        $findArgs = [];
//        if (null !== $chat->getId()) {
//            $findArgs['id'] = $chat->getId();
//        }
//        else {
//            return false;
//        }
////        $findArgs['login'] = $chat->getLogin();
//        $found = $this->getDoctrine()
//            ->getRepository(Chat::class)->findOneBy($findArgs);
//        return !($found === null);
//    }
}

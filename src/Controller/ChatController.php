<?php

namespace App\Controller;

use App\Entity\Chat;
use App\Entity\ChatUser;
use App\Entity\User;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class ChatController extends Controller
{
    /**
     * @Route("/chat", name="chat")
     */
    public function index()
    {
        return $this->render('chat/index.html.twig', [
            'controller_name' => 'ChatController',
        ]);
    }

    /**
     * @Route(
     *     "/chat/create",
     *     methods={"POST"}
     * )
     *
     * @param Request $request Объект запроса
     *
     * @throws \Exception
     */
    public function createChat(Request $request)
    {
        // Чтение пользователя из запроса и проверка его наличия
        $userRequest = new User();
        $userRequest->setLogin($request->request->get('login'));
        $userRequest->setPassword($request->request->get('password'));
//        $userDB = new User();
        $userDB = $this->getDoctrine()
            ->getRepository(User::class)
            ->findOneBy(['login' => $userRequest->getLogin(), 'password' => $userRequest->getPassword()]);
        if ($userRequest->getLogin() === $userDB->getLogin()
            && $userRequest->getPassword() === $userDB->getPassword())
        {
            // Работа с БД
            $entityManager = $this->getDoctrine()->getManager();
            // Запись нового чата БД
            $chat = new Chat();
            $chat->setCode();
            $entityManager->persist($chat);
            $entityManager->flush();
            // Добавление пользователя в чат
            // Для начала создатель и первый
            $firstUserDB = $this->getDoctrine()
                ->getRepository(User::class)
                ->findOneBy(['id' => '1']);
            $firstChatUser = new ChatUser();
            $firstChatUser->setChatId($chat->getId());
            $firstChatUser->setUserId($firstUserDB->getId());
            $entityManager->persist($firstChatUser);
            $chatUser = new ChatUser();
            $chatUser->setChatId($chat->getId());
            $chatUser->setUserId($userDB->getId());
            $entityManager->persist($chatUser);

            $entityManager->flush();
        }

//        // Ответ клиенту
//        $response = new Response();
//        $response->setStatusCode(Response::HTTP_OK);
//        $response->headers->set('Content-Type', 'application/json');
//        $response->setContent(json_encode($user->expose()));
//
//        $response->send();
    }
}

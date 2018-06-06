<?php

namespace App\Controller;

use App\Entity\Chat;
use App\Entity\Message;
use App\Entity\User;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class MessageController extends Controller
{
    /**
     * @Route("/message", name="message")
     */
    public function index()
    {
        return $this->render('message/index.html.twig', [
            'controller_name' => 'MessageController',
        ]);
    }

    /**
     * @Route(
     *     "/msg/send",
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
            // Чтение чата из запроса и проверка его наличия
//            $chatRequest = new Chat();
//            $chatRequest->setCode($request->request->get('login'));
            $chatRequest = $this->getDoctrine()
                ->getRepository(Chat::class)
                ->findOneBy(['id' => '1']);
//
            // Работа с БД
            $entityManager = $this->getDoctrine()->getManager();
            // Запись нового чата БД
            $msg = new Message();
            $msg->setChatId($chatRequest->getId());
            $msg->setSenderUserId($userDB->getId());
            $msg->setContent($request->request->get('content'));
            $entityManager->persist($msg);
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

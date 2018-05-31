<?php

namespace App\Controller;

use Exception;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use App\Entity\User;

class UserController extends Controller
{
    /**
     * @Route("/me", name="user_about")
     */
    public function index()
    {
        return $this->render('user/index.html.twig', [
            'controller_name' => 'UserController',
        ]);
    }

        /**
     * @param Request $request Объект запроса
     *
     * @Route(
     *     "/user/add",
     *     methods={"POST"},
     *     name="user_add"
     * )
     *
     * @throws Exception
     *
     */
    public function addUser(Request $request)
    {
        // Запись в БД
        $entityManager = $this->getDoctrine()->getManager();

        $user = new User();
        $user->setChatWas(0);

        $user->setLogin($request->request->get('login'));
        $user->setPassword(random_int(1000, 9999));

        $entityManager->persist($user);
        $entityManager->flush();

        // Чтение из БД
        $login = $request->request->get('login');
        $user = $this->getDoctrine()
            ->getRepository(User::class)
            ->findOneBy(['login' => $login]);

        // Ответ клиенту
        $response = new Response();
        $response->setStatusCode(Response::HTTP_OK);
        $response->headers->set('Content-Type', 'application/json');
        $response->setContent(json_encode($user->expose()));

        $response->send();
    }
}

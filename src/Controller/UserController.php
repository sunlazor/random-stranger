<?php

namespace App\Controller;

use App\Helpers\UserHelper;
use Exception;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class UserController extends Controller
{

    private $userHelper;

    public function __construct(UserHelper $userHelper)
    {
        $this->userHelper = $userHelper;
    }

//    /**
//     * @Route("/me", name="user_about")
//     */
//    public function index()
//    {
//        return $this->render('user/index.html.twig', [
//            'controller_name' => 'UserController',
//        ]);
//    }

    /**
     * Создание нового пользователя для общения в чате
     *
     * @param Request $request Объект запроса
     * @param ValidatorInterface $validator Валидатор классов
     * @return Response Возвращает JSON с объектом
     * @throws Exception Исключение от random_int в случае нехватки энтропии
     * @Route(
     *     "/users/signup",
     *     methods={"POST"},
     *     name="user_signup"
     * )
     *
     */
    public function userSignUp(Request $request, ValidatorInterface $validator): Response
    {
        $user = $this->userHelper->extractUser($request);
        // TODO: реализовать пользовательские пароли
        // Временно для простоты
        $user->setPassword(random_int(1000, 9999));
        // Проверка валидности логина
        $errors = $validator->validate($user);
        // Валидация логина
        if (\count($errors) > 0) {
            $msg = [
                'Error' => 'Validation failed',
                'Notice' => 'a-zA-Z0-9-_ are allowed, but you can\'t start your login with -_',
                'Received' => $user->getLogin()];
            // Ответ клиенту
            $response = new JsonResponse($msg, Response::HTTP_UNPROCESSABLE_ENTITY);
        }
        // Проверка наличия пользователя
        else if ($this->userHelper->isUserExists($user))
        {
            $msg = [
                'Error' => 'User exists',
                'Notice' => 'Choose a different login',
                'Received' => $user->getLogin()];
            // Ответ клиенту
            $response = new JsonResponse($msg, Response::HTTP_CONFLICT);
        }
        else
        {
            // Доступ и запись в БД
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($user);
            $entityManager->flush();
            // Ответ клиенту
            $msg = [
                'Success' => 'User created'];
            $response = new JsonResponse($msg, Response::HTTP_OK);
        }

        return $response;
    }
}

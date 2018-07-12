<?php

namespace App\Controller;

use App\Helpers\UserHelper;
use Exception;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use App\Entity\User;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use App\Utils;

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
     * @param Request $request Объект запроса
     *
     * @param ValidatorInterface $validator Валидатор классов
     * @return Response Возвращает JSON с объектом
     * @throws Exception Исключение от random_int в случае нехватки энтропии
     * @Route(
     *     "/user/add",
     *     methods={"POST"},
     *     name="user_add"
     * )
     *
     */
    public function addUser(Request $request, ValidatorInterface $validator): Response
    {
        $login = $this->userHelper->extractUser($request);
        $user = new User();
        $user->setLogin($login);
        $user->setPassword(random_int(1000, 9999));
        // Проверка валидности логина
        $errors = $validator->validate($user);
        if (\count($errors) > 0) {
            $errorsMsg = ['Validation error:' => (string) $errors];
            // Ответ клиенту
            $response = new JsonResponse($errorsMsg, Response::HTTP_UNPROCESSABLE_ENTITY);
        }
        else
        {
            // Доступ и запись в БД
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($user);
            $entityManager->flush();
            // Ответ клиенту
            $response = new JsonResponse($user->expose(), Response::HTTP_OK);
        }

        return $response;
    }

//    /**
//     * Проверка наличия данного пользователя в БД
//     * Проверка идет только по login и id (если есть)
//     *
//     * @param User $user Объект с пользователем для проверки
//     * @return bool Возвращает true если пользователь найден. false если нет или дан пустой объект
//     */
//    public function isUserExists(User $user): bool
//    {
//        if (null === $user) {
//            return false;
//        }
//        $findArgs = [];
//        if (null !== $user->getId()) {
//            $findArgs['id'] = $user->getId();
//        }
//        $findArgs['login'] = $user->getLogin();
//        $found = $this->getDoctrine()
//            ->getRepository(User::class)->findOneBy($findArgs);
//        return !($found === null);
//    }
}

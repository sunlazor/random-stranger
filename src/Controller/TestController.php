<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class TestController extends Controller
{
    /**
     * @Route( "/test", methods={"GET"} )
     *
     */
    public function test(): JsonResponse
    {
        return new JsonResponse('OK', Response::HTTP_OK);
    }
}

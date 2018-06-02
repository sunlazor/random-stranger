<?php
// src/Controller/LuckyController.php
namespace App\Controller;

use Psr\Log\LoggerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Routing\Annotation\Route;


class LuckyController extends Controller
{

    /**
     * Class LuckyController
     * package App\Controller
     *
     * @Route("/lucky/number/{max}", name="app_lucky_number")
     */
    public function number($max = 100, LoggerInterface $logger)
    {
        $number = mt_rand(0, $max);

        $logger->info('We are logging!');

        return $this->render('lucky/number.html.twig', array(
            'number' => $number,
        ));
    }
}
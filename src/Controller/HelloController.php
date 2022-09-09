<?php

namespace App\Controller;

use Psr\Log\LoggerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

class HelloController extends AbstractController
{
    #[Route('/hello', name:'hello')]
    public function index($msg='Hello!')
    {
        return $this->render('hello/index.html.twig', [
            'controller' => 'HelloController',
            'action' => 'index',
            'prev_action' => '(none)',
            'message' => $msg,
        ]);
    }

    #[Route('/other/{action}/{msg}', name:'other')]
    public function other($action, $msg)
    {
        return $this->render('hello/index.html.twig', [
            'controller' => 'HelloController',
            'action' => 'other',
            'prev_action' => $action,
            'message' => $msg,
        ]);
    }
}

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
    public function index(Request $request)
    {
        if ($request->getMethod() == 'POST'){
            $input = $request->request->get('input');
            $msg = 'こんにちは、' . $input . 'さん！';
        } else {
            $msg = 'お名前は？';
        }
        return $this->render('hello/index.html.twig', [
            'title' => 'Hello',
            'message' => $msg,
        ]);
    }
}

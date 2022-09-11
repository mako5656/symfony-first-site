<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HelloController extends AbstractController
{
    #[Route('/hello', name:'hello')]
    public function index(Request $request)
    {
        return $this->render('hello/index.html.twig', [
            'title' => 'Hello',
            'message' => 'これはサンプルのテンプレート画面です。',
        ]);
    }
}

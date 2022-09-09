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
        return $this->render('hello/index.html.twig', [
            'title' => 'Hello',
            'message' => 'あなたのお名前：',
        ]);
    }

    #[Route('/other', name:'other')]
    public function other(Request $request)
    {
        /**
         * $request->request がPOST送信された値を扱うオブジェクト
         * requestにせっていされたオブジェクトのgetメソッドを使って送信フォームの値を取り出す
         * 引数には、フォームのname属性を指定
        */
        $input = $request->request->get('input');
        $msg = 'こんにちは、' . $input . 'さん！';
        return $this->render('hello/index.html.twig', [
            'title' => 'Hello',
            'message' => $msg,
        ]);
    }
}

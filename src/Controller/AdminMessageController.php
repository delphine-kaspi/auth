<?php

namespace App\Controller;

use App\Repository\MessageRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/admin/messages', name: 'admin_messages_')]
class AdminMessageController extends AbstractController
{
    #[Route('', name: 'index')]
    public function index(MessageRepository $repo): Response
    {
        $messages = $repo->findBy([], ['createdAt' => 'DESC']);

        return $this->render('admin_message/index.html.twig', [
            'messages' => $messages,
        ]);
    }
}
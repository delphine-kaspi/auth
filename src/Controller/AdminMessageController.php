<?php

namespace App\Controller;

use App\Entity\Message;
use App\Repository\MessageRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[IsGranted('ROLE_ADMIN')]
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

    #[Route('/{id}', name: 'show')]
    public function show(Message $message): Response
    {
        return $this->render('admin_message/show.html.twig', [
            'message' => $message,
        ]);
    }

    #[Route('/{id}/supprimer', name: 'delete', methods: ['POST'])]
    public function delete(Request $request, Message $message, EntityManagerInterface $em): Response
    {
        if ($this->isCsrfTokenValid('delete' . $message->getId(), $request->getPayload()->getString('_token'))) {
            $em->remove($message);
            $em->flush();
            $this->addFlash('success', 'Message supprimé.');
        }

        return $this->redirectToRoute('admin_messages_index');
    }
}
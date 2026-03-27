<?php

namespace App\Controller;

use App\Entity\Representation;
use App\Entity\Spectacle;
use App\Form\RepresentationType;
use App\Repository\RepresentationRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[IsGranted('ROLE_ADMIN')]
#[Route('/admin/representation')]
final class AdminRepresentationController extends AbstractController
{
    #[Route('', name: 'app_admin_representation_index', methods: ['GET'])]
    public function index(RepresentationRepository $representationRepository): Response
    {
        return $this->render('admin_representation/index.html.twig', [
            'representations' => $representationRepository->findAllWithDetails(),
        ]);
    }

    #[Route('/new/{id}', name: 'app_admin_representation_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager, Spectacle $spectacle): Response
    {
        $representation = new Representation();
        $form = $this->createForm(RepresentationType::class, $representation);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $representation->setSpectacle($spectacle);
            $entityManager->persist($representation);
            $entityManager->flush();

            return $this->redirectToRoute('app_admin_representation_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('admin_representation/new.html.twig', [
            'representation' => $representation,
            'form' => $form,
            'spectacle' => $spectacle,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_admin_representation_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Representation $representation, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(RepresentationType::class, $representation);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_admin_representation_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('admin_representation/edit.html.twig', [
            'representation' => $representation,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_admin_representation_delete', methods: ['POST'])]
    public function delete(Request $request, Representation $representation, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$representation->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($representation);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_admin_representation_index', [], Response::HTTP_SEE_OTHER);
    }
}

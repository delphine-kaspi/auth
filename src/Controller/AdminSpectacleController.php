<?php

namespace App\Controller;

use App\Entity\Artiste;
use App\Entity\Spectacle;
use App\Form\SpectacleType;
use App\Repository\SpectacleRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/admin/spectacle')]
final class AdminSpectacleController extends AbstractController
{
    #[Route('/{id}', name: 'app_admin_spectacle_index', methods: ['GET'])]
    public function index(SpectacleRepository $spectacleRepository, Artiste $artiste): Response
    {
        return $this->render('admin_spectacle/index.html.twig', [
            'spectacles' => $spectacleRepository->findBy(['artiste' => $artiste]),
            'artiste' => $artiste
        ]);
    }

    #[Route('/new/{id}', name: 'app_admin_spectacle_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager, Artiste $artiste): Response
    {
        $spectacle = new Spectacle();
        $form = $this->createForm(SpectacleType::class, $spectacle);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $spectacle->setArtiste($artiste);
            $entityManager->persist($spectacle);
            $entityManager->flush();

            return $this->redirectToRoute('app_admin_spectacle_index', ['id' => $artiste->getId() ], Response::HTTP_SEE_OTHER);
        }

        return $this->render('admin_spectacle/new.html.twig', [
            'spectacle' => $spectacle,
            'form' => $form,
            'artiste' => $artiste
        ]);
    }

    #[Route('/{id}', name: 'app_admin_spectacle_show', methods: ['GET'])]
    public function show(Spectacle $spectacle): Response
    {
        return $this->render('admin_spectacle/show.html.twig', [
            'spectacle' => $spectacle,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_admin_spectacle_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Spectacle $spectacle, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(SpectacleType::class, $spectacle);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

             return $this->redirectToRoute('app_admin_spectacle_index', ['id' => $spectacle->getArtiste()->getId() ], Response::HTTP_SEE_OTHER);
        }

        return $this->render('admin_spectacle/edit.html.twig', [
            'spectacle' => $spectacle,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_admin_spectacle_delete', methods: ['POST'])]
    public function delete(Request $request, Spectacle $spectacle, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$spectacle->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($spectacle);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_admin_spectacle_index', ['id' => $spectacle->getArtiste()->getId() ], Response::HTTP_SEE_OTHER);
    }
}

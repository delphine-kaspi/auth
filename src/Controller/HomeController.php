<?php

namespace App\Controller;

use App\Entity\Artiste;
use App\Entity\Spectacle;
use App\Repository\ArtisteRepository;
use App\Repository\SpectacleRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class HomeController extends AbstractController
{
    #[Route('/', name: 'app_home')]
    public function index(
        ArtisteRepository $artisteRepository,
        SpectacleRepository $spectacleRepository
    ): Response {
        return $this->render('home/index.html.twig', [
            'artistes'   => $artisteRepository->findAll(),
            'spectacles' => $spectacleRepository->findAll(),
        ]);
    }

    #[Route('/artistes', name: 'app_artiste_index', methods: ['GET'])]
    public function artistes(ArtisteRepository $artisteRepository): Response
    {
        return $this->render('home/artistes.html.twig', [
            'artistes' => $artisteRepository->findAll(),
        ]);
    }

    #[Route('/artiste/{id}', name: 'app_artiste_show', methods: ['GET'])]
    public function show(Artiste $artiste): Response
    {
        return $this->render('home/artiste.html.twig', [
            'artiste' => $artiste,
        ]);
    }

    #[Route('/spectacle/{id}', name: 'app_spectacle_show', methods: ['GET'])]
    public function showSpectacle(Spectacle $spectacle): Response
    {
        return $this->render('home/spectacle.html.twig', [
            'spectacle' => $spectacle,
        ]);
    }
}
<?php

namespace App\Controller;

use App\Entity\Artiste;
use App\Repository\ArtisteRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

final class HomeController extends AbstractController
{
    #[Route('/', name: 'app_home')]
    public function index(ArtisteRepository $artisteRepository): Response
    {
        $artistes = $artisteRepository->findAll();

        return $this->render('home/index.html.twig', [
            'artistes' => $artistes
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
}
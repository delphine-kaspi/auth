<?php

namespace App\Controller;

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
            'artistes' => $artistes,
        ]);
    }
}
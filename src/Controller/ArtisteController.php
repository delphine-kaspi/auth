<?php

namespace App\Controller;

use App\Entity\Artiste;
use App\Repository\ArtisteRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ArtisteController extends AbstractController
{
    #[Route('/artistes', name: 'artistes')]
    public function index(ArtisteRepository $repo): Response
    {
        return $this->render('artistes.html.twig', [
            'artistes' => $repo->findAll(),
        ]);
    }

    #[Route('/artiste/{id}', name: 'app_artiste_show')]
    public function show(Artiste $artiste): Response
    {
        return $this->render('artiste.html.twig', [
            'artiste' => $artiste,
        ]);
    }
}
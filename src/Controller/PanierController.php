<?php

namespace App\Controller;

use App\Repository\ReservationRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[IsGranted('ROLE_USER')]
final class PanierController extends AbstractController
{
    #[Route('/panier', name: 'app_panier')]
    public function index(ReservationRepository $reservationRepository): Response
    {
        $reservations = $reservationRepository->findReservationsAVenir($this->getUser());

        return $this->render('panier/index.html.twig', [
            'reservations' => $reservations,
        ]);
    }
}

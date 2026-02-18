<?php

namespace App\Controller;

use App\Entity\Representation;
use App\Entity\Reservation;
use App\Form\ReservationType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class ReservationController extends AbstractController
{
    #[Route('/reservation/{id}', name: 'reservation')]
    public function index(Request $request, EntityManagerInterface $em, ?Representation $representation): Response
    {
        if (!$representation) {
            throw $this->createNotFoundException('La représentation n’existe pas.');
        }

        $reservation = new Reservation();
        $reservation->setRepresentation($representation);
        $reservation->setUser($this->getUser());
        $reservation->setDateResa(new \DateTime()); 




        $form = $this->createForm(ReservationType::class, $reservation);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em->persist($reservation);
            $em->flush();

            $this->addFlash('success', 'Votre réservation a été enregistrée !');

            return $this->redirectToRoute('reservation', ['id' => $representation->getId()]);
        }

        return $this->render('reservation/index.html.twig', [
            'representation' => $representation,
            'form' => $form->createView(),
        ]);
    }
}
<?php

namespace App\Controller;

use App\Entity\Reservation;
use App\Entity\User;
use App\Repository\ReservationRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Address;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[IsGranted('ROLE_USER')]
final class PanierController extends AbstractController
{
    #[Route('/panier', name: 'app_panier')]
    public function index(ReservationRepository $reservationRepository): Response
    {
        /** @var User $user */
        $user = $this->getUser();

        $reservations = $reservationRepository->findReservationsAVenir($user);

        return $this->render('panier/index.html.twig', [
            'reservations' => $reservations,
        ]);
    }

    #[Route('/panier/{id}/supprimer', name: 'app_panier_delete', methods: ['POST'])]
    public function delete(Request $request, Reservation $reservation, EntityManagerInterface $em): Response
    {
        /** @var User $user */
        $user = $this->getUser();

        if ($reservation->getUser() !== $user) {
            throw $this->createAccessDeniedException();
        }

        if ($this->isCsrfTokenValid('delete' . $reservation->getId(), $request->getPayload()->getString('_token'))) {
            $em->remove($reservation);
            $em->flush();
            $this->addFlash('success', 'Réservation annulée.');
        }

        return $this->redirectToRoute('app_panier');
    }

    #[Route('/panier/{id}/modifier', name: 'app_panier_update', methods: ['POST'])]
    public function update(Request $request, Reservation $reservation, EntityManagerInterface $em): Response
    {
        /** @var User $user */
        $user = $this->getUser();

        if ($reservation->getUser() !== $user) {
            throw $this->createAccessDeniedException();
        }

        $nbPlace = (int) $request->request->get('nbPlace');

        if ($nbPlace < 1) {
            $this->addFlash('danger', 'Le nombre de places doit être au moins 1.');
            return $this->redirectToRoute('app_panier');
        }

        if ($this->isCsrfTokenValid('update' . $reservation->getId(), $request->getPayload()->getString('_token'))) {
            $reservation->setNbPlace($nbPlace);
            $em->flush();
            $this->addFlash('success', 'Réservation mise à jour.');
        }

        return $this->redirectToRoute('app_panier');
    }

    #[Route('/panier/confirmer', name: 'app_panier_confirm', methods: ['POST'])]
    public function confirm(ReservationRepository $reservationRepository, MailerInterface $mailer): Response
    {
        /** @var User $user */
        $user = $this->getUser();

        $reservations = $reservationRepository->findReservationsAVenir($user);

        if (empty($reservations)) {
            $this->addFlash('danger', 'Votre panier est vide.');
            return $this->redirectToRoute('app_panier');
        }

        $total = 0;
        foreach ($reservations as $reservation) {
            $total += $reservation->getNbPlace() * $reservation->getRepresentation()->getPrix();
        }

        $email = (new TemplatedEmail())
            ->from(new Address('no-reply@kastone.fr', 'No Reply Kastone'))
            ->to((string) $user->getEmail())
            ->subject('Confirmation de vos réservations Kastone')
            ->htmlTemplate('email/confirmation_reservation.html.twig')
            ->context([
                'user' => $user,
                'reservations' => $reservations,
                'total' => $total,
            ]);

        $mailer->send($email);

        $this->addFlash('success', 'Un email de confirmation vous a été envoyé à ' . $user->getEmail() . '.');

        return $this->redirectToRoute('app_panier');
    }
}

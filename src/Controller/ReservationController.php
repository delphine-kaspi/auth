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
use Symfony\Component\Security\Http\Attribute\IsGranted;
 
final class ReservationController extends AbstractController
{
    #[IsGranted('ROLE_USER')]
    #[Route('/reservation/{id}', name: 'reservation')]
    public function index(Request $request, EntityManagerInterface $em, ?Representation $representation): Response
    {
        if (!$representation) {
            throw $this->createNotFoundException('La représentation n\'existe pas.');
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
 
            return $this->redirectToRoute('reservation_confirmation', ['id' => $reservation->getId()]);
        }
 
        return $this->render('reservation/index.html.twig', [
            'representation' => $representation,
            'form' => $form->createView(),
        ]);
    }
 
    #[IsGranted('ROLE_USER')]
    #[Route('/reservation/confirmation/{id}', name: 'reservation_confirmation')]
    public function confirmation(Reservation $reservation): Response
    {
        // Sécurité : l'utilisateur ne peut voir que ses propres réservations
        if ($reservation->getUser() !== $this->getUser()) {
            throw $this->createAccessDeniedException('Accès refusé.');
        }
 
        return $this->render('reservation/confirmation.html.twig', [
            'reservation' => $reservation,
        ]);
    }
}
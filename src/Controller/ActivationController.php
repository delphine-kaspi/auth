<?php
 
namespace App\Controller;
 
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
 
class ActivationController extends AbstractController
{
    #[Route('/activation/{token}', name: 'app_activation')]
    public function activation(string $token, UserRepository $userRepository, EntityManagerInterface $entityManager): Response
    {
        $user = $userRepository->findOneBy(['token' => $token]);
 
        if (!$user) {
            $this->addFlash('danger', 'Ce lien d\'activation est invalide ou a déjà été utilisé.');
            return $this->redirectToRoute('app_login');
        }
 
        $user->setToken(null);
        $entityManager->flush();
 
        $this->addFlash('success', 'Votre compte est activé, vous pouvez vous connecter !');
        return $this->redirectToRoute('app_login');
    }
}
 
<?php

namespace App\Controller;

use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

class LoginController extends AbstractController
{
    #[Route('/login', name: 'app_login')]
    public function index(Request $request, SessionInterface $session, UserRepository $userRepository): Response
    {
        $error = null;

        if ($request->isMethod('POST')) {
            $email = $request->request->get('email');
            $password = $request->request->get('password');

            $user = $userRepository->findOneBy(['email' => $email]);

            if ($user && $user->getPassword() === $password) {
                $session->set('isConnected', true);
                return $this->redirectToRoute('app_home');
            } else {
                $error = 'Invalid credentials';
            }
        }

        return $this->render('login/index.html.twig', [
            'error' => $error,
        ]);
    }

    #[Route('/logout', name: 'app_logout')]
    public function logout(SessionInterface $session): Response
    {
        $session->remove('isConnected');
        return $this->redirectToRoute('app_home');
    }
}

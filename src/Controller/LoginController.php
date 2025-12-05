<?php

namespace App\Controller;

use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class LoginController extends AbstractController
{
    #[Route('/login', name: 'app_login')]
    public function login(Request $request): Response
    {
        $session = $request->getSession();
        // pre-setting login and password for testing purposes
        $session->set('user_login', 'test@test.com');
        $session->set('user_pass', 'password');

        $user = new User();
        $form = $this->createFormBuilder($user)
            ->add('email', EmailType::class)
            ->add('password', PasswordType::class)
            ->add('submit', SubmitType::class, ['label' => 'Connexion'])
            ->getForm();

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();
            $user_login = $session->get('user_login');
            $user_pass = $session->get('user_pass');

            if ($data->getEmail() === $user_login && $data->getPassword() === $user_pass) {
                $session->set('isConnected', true);
                return $this->redirectToRoute('app_home'); // Assuming 'app_home' is the name of your home route
            } else {
                $this->addFlash('error', 'Identifiants incorrects');
            }
        }

        return $this->render('login/index.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route('/logout', name: 'app_logout')]
    public function logout(Request $request): Response
    {
        $session = $request->getSession();
        $session->remove('isConnected');

        return $this->redirectToRoute('app_login');
    }
}

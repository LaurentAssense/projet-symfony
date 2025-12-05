<?php

namespace App\Controller;

use App\Form\RegistrationType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class RegistrationController extends AbstractController
{
    #[Route('/register', name: 'app_register')]
    public function register(Request $request): Response
    {
        $form = $this->createForm(RegistrationType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();
            $session = $request->getSession();
            $session->set('user_login', $data['email']);
            $session->set('user_pass', $data['password']);

            return $this->redirectToRoute('success');
        }

        return $this->render('registration/index.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route('/register/success', name: 'success')]
    public function success(Request $request): Response
    {
        $session = $request->getSession();
        $email = $session->get('user_login');
        
        return new Response("Merci {$email} pour votre inscription.");
    }
}

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
            // data_class est null, donc les données sont un tableau
            $data = $form->getData();
            $email = $data['email'];

            // Redirection vers une page de succès en passant l'email
            return $this->redirectToRoute('app_register_success', ['email' => $email]);
        }

        return $this->render('registration/index.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route('/register/success/{email}', name: 'app_register_success')]
    public function success(string $email): Response
    {
        return new Response("Merci {$email} pour votre inscription.");
    }
}

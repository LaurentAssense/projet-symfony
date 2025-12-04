<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;


class ClientController extends AbstractController {
    
    function info(string $prenom): Response
    {
        if (!preg_match('/^[a-zA-Z-]+$/', $prenom)) {
            return new Response(
                'Le prénom ne doit contenir que des lettres et des tirets.',
                Response::HTTP_BAD_REQUEST
            );
        }

        return new Response(
            "Le prenom du client est : $prenom"
        );
    }
}
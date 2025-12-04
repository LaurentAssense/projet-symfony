<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class ClientController extends AbstractController {
    
    #[Route('/client/prenom/{prenom}', 'app_client_info')]
    function info(string $prenom): Response
    {
        return new Response(
            "Le prenom du client est : $prenom"
        );
    }
}
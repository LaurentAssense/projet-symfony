<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ClientController extends AbstractController
{
    /**
     * Route ouverte seulement de 8h à 17h, sinon on exécute ferme
     * @return Response
     */
    #[Route("/client", name:"client", options: ["ouverture" => "8-17"])]
    public function home() : Response
    {
        return new Response("Bonjour");
    }

    public function ferme() : Response
    {
        return new Response("Nous sommes fermés !");
    }
}

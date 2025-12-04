<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ImageController extends AbstractController
{
    #[Route('/img/home', name: 'app_img_home')]
    public function home(): Response
    {
        return $this->render('img/home.html.twig', [
            'title' => 'Site Image',
        ]);
    }
}

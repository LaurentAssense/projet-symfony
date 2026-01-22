<?php

namespace App\Controller;

use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
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
        return $this->render('client/index.html.twig', [
            'message' => 'Nous sommes ouverts !',
        ]);
    }

    public function ferme() : Response
    {
        return $this->render('client/index.html.twig', [
            'message' => 'Nous sommes fermés !',
        ]);
    }

    #[Route('/client/prenom/{prenom}', name: 'client_info', requirements: ['prenom' => '[a-zA-Z]+(-[a-zA-Z]+)*'])]
    public function info(string $prenom): Response
    {
        return new Response('Clients trouvés pour le prénom : ' . $prenom);
    }

    #[Route('/user/liste', name: 'app_user_list')]
    public function listUsers(SessionInterface $session, UserRepository $userRepository): Response
    {
        if (!$session->get('isConnected')) {
            $this->addFlash('error', 'You must be logged in to see this page.');
            return $this->redirectToRoute('app_login');
        }

        $users = $userRepository->findAll();

        return $this->render('user/list.html.twig', [
            'users' => $users,
        ]);
    }

}

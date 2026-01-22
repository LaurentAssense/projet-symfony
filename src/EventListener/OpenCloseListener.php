<?php

namespace App\EventListener;

use App\Controller\ClientController;
use Psr\Log\LoggerInterface;
use Symfony\Component\HttpKernel\Event\ControllerEvent;
use Symfony\Component\Routing\RouterInterface;

class OpenCloseListener
{
    private $logger;
    private $router;
    private ClientController $clientController;

    public function __construct(LoggerInterface $logger, RouterInterface $router, ClientController $clientController)
    {
        $this->logger = $logger;
        $this->router = $router;
        $this->clientController = $clientController;
    }

    public function onKernelController(ControllerEvent $event)
    {
        $this->logger->info('Vérification ouverture');

        $routeName = $event->getRequest()->attributes->get('_route');
        if (!$routeName) {
            return;
        }

        $route = $this->router->getRouteCollection()->get($routeName);
        if (!$route || !$route->hasOption('ouverture')) {
            return;
        }

        $ouverture = $route->getOption('ouverture');
        list($heureDebut, $heureFin) = explode('-', $ouverture);

        $heureActuelle = (int)date('G');

        if ($heureActuelle < $heureDebut || $heureActuelle >= $heureFin) {
            $event->setController([$this->clientController, 'ferme']);
        }
    }
}

<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class WatchlistController extends AbstractController
{
    #[Route('/watchlist', name: 'app_watchlist')]
    public function index(): Response
    {
        return $this->render('watchlist/index.html.twig', [
            'controller_name' => 'WatchlistController',
        ]);
    }
}

<?php

namespace App\Controller;

use App\Entity\Musee;
use App\Form\MuseeType;
use App\Repository\MuseeRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('client/musee')]
class MuseeClientController extends AbstractController
{
    #[Route('/', name: 'app_musee_index_client', methods: ['GET', 'POST'])]
    public function index(Request $request, MuseeRepository $museeRepository): Response
    {
        if ($request->getMethod() == 'POST' && $request->get("search") != null && $request->get("search") != "") {

                $list = $museeRepository->findBy(array('name' => $request->get("search")));
        } else {
            $list = $museeRepository->findAll();
        }
        return $this->render('musee_front/index.html.twig', [
            'musees' => $list,
        ]);
    }


    #[Route('/{id}', name: 'app_musee_show_client', methods: ['GET'])]
    public function show(Musee $musee): Response
    {
        return $this->render('musee_front/show.html.twig', [
            'musee' => $musee,
        ]);
    }
}

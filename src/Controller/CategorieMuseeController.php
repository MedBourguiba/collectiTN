<?php

namespace App\Controller;

use App\Entity\CategorieMusee;
use App\Form\CategorieMuseeType;
use App\Repository\CategorieMuseeRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/categorie/musee')]
class CategorieMuseeController extends AbstractController
{
    #[Route('/', name: 'app_categorie_musee_index', methods: ['GET'])]
    public function index(CategorieMuseeRepository $categorieMuseeRepository): Response
    {
        return $this->render('categorie_musee/index.html.twig', [
            'categorie_musees' => $categorieMuseeRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_categorie_musee_new', methods: ['GET', 'POST'])]
    public function new(Request $request, CategorieMuseeRepository $categorieMuseeRepository): Response
    {
        $categorieMusee = new CategorieMusee();
        $form = $this->createForm(CategorieMuseeType::class, $categorieMusee);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $categorieMuseeRepository->save($categorieMusee, true);

            return $this->redirectToRoute('app_categorie_musee_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('categorie_musee/new.html.twig', [
            'categorie_musee' => $categorieMusee,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_categorie_musee_show', methods: ['GET'])]
    public function show(CategorieMusee $categorieMusee): Response
    {
        return $this->render('categorie_musee/show.html.twig', [
            'categorie_musee' => $categorieMusee,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_categorie_musee_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, CategorieMusee $categorieMusee, CategorieMuseeRepository $categorieMuseeRepository): Response
    {
        $form = $this->createForm(CategorieMuseeType::class, $categorieMusee);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $categorieMuseeRepository->save($categorieMusee, true);

            return $this->redirectToRoute('app_categorie_musee_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('categorie_musee/edit.html.twig', [
            'categorie_musee' => $categorieMusee,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_categorie_musee_delete', methods: ['POST'])]
    public function delete(Request $request, CategorieMusee $categorieMusee, CategorieMuseeRepository $categorieMuseeRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$categorieMusee->getId(), $request->request->get('_token'))) {
            $categorieMuseeRepository->remove($categorieMusee, true);
        }

        return $this->redirectToRoute('app_categorie_musee_index', [], Response::HTTP_SEE_OTHER);
    }
}

<?php

namespace App\Controller;

use ApiPlatform\Symfony\Messenger\ContextStamp;
use App\Services\PdfService;
use App\Services\MailerService;
use App\Entity\Reclamation;
use App\Form\ReclamationType;
use App\Repository\ReclamationRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Security\Core\User\UserInterface;

#[Route('/reclamation')]
class ReclamationController extends AbstractController
{ 
    #[Route('/', name: 'app_reclamation_index', methods: ['GET'])]
public function index(ReclamationRepository $reclamationRepository): Response
{
    return $this->render('reclamation/index.html.twig', [
        'reclamations' => $reclamationRepository->findAll(),
    ]);
}

    #[Route('/new', name: 'app_reclamation_new', methods: ['GET', 'POST'])]
    public function new(Request $request, ReclamationRepository $reclamationRepository,UserInterface $user): Response
    {
        $reclamation = new Reclamation();
        $form = $this->createForm(ReclamationType::class, $reclamation);
        $form->handleRequest($request);
        $reclamation->setUser($user);

        if ($form->isSubmitted() && $form->isValid()) {
            $reclamationRepository->save($reclamation, true);
            $message = " a été ajouté avec succès";

            return $this->redirectToRoute('app_reclamation_new', [], Response::HTTP_SEE_OTHER);
            
        }

        return $this->renderForm('reclamation/new.html.twig', [
            'reclamation' => $reclamation,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_reclamation_show', methods: ['GET'])]
    public function show(Reclamation $reclamation): Response
    {
        return $this->render('reclamation/show.html.twig', [
            'reclamation' => $reclamation,
        ]);
    }
    #[Route('/pdf/{id}', name: 'app_reclamation.pdf')]
    public function generatePdfReclamation(Reclamation $reclamation =null ,PdfService $pdf)
    {
        $html =$this ->render ('reclamation/pdf.html.twig', [
            'reclamation' => $reclamation,
        ]);
        $pdf->showPdfFile($html);
    }

    #[Route('/{id}/edit', name: 'app_reclamation_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Reclamation $reclamation, ReclamationRepository $reclamationRepository): Response
    {
        $form = $this->createForm(ReclamationType::class, $reclamation);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $reclamationRepository->save($reclamation, true);

            return $this->redirectToRoute('app_reclamation_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('reclamation/edit.html.twig', [
            'reclamation' => $reclamation,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_reclamation_delete', methods: ['POST'])]
    public function delete(Request $request, Reclamation $reclamation, ReclamationRepository $reclamationRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$reclamation->getId(), $request->request->get('_token'))) {
            $reclamationRepository->remove($reclamation, true);
        }

        return $this->redirectToRoute('app_reclamation_index', [], Response::HTTP_SEE_OTHER);
    }
    #[Route('/reclamation/advanced-search', name: 'app_reclamation_advanced_search', methods: ['GET'])]
    public function advancedSearch(Request $request): JsonResponse
    {
        // Get search query from request
        $query = $request->query->get('query');
        
        // Perform search query (replace with your actual search logic)
        $reclamations = $this->getDoctrine()->getRepository(Reclamation::class)->findBy(['reclamation.id' => $query]);
        
        // Return search results as JSON
        return new JsonResponse($reclamations);
    }
    // #[Route('/search/reclamation', name: 'search_reclamation', methods: ['GET'])]
    // public function search(Request $request, ReclamationRepository $repository)
    // {
    //     $searchTerm = $request->query->get('q');

    //     $reclamation = $repository->search($searchTerm);

    //     return $this->render('reclamation/index.html.twig', [
    //         'reclamation' => $reclamation,
    //     ]);
    // }
}

<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Doctrine\Persistence\ManagerRegistry; 
use App\Entity\Category;
use App\Entity\Item;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\ItemRepository;
use Symfony\Component\HttpFoundation\Request;
use App\Repository\CategoryRepository;

#[Route('/client')]
class FrontController extends AbstractController
{
    #[Route('/', name: 'app_home')]
    public function index(ManagerRegistry $doctrine,ManagerRegistry $doctrine2): Response
    {   
        $entityManager = $doctrine->getManager();
        $categories = $entityManager->getRepository(Category::class)->findAll();
        $entityManager2 = $doctrine2->getManager();
        $items = $entityManager2->getRepository(Item::class)->findAll();
        return $this->render('/Home.html.twig', [
            'controller_name' => 'HomeController',
            'categories' => $categories,
            'items' => $items,
            
            
        ]);
    }

    #[Route('/items', name: 'list_client')]
    public function showItem(Request $request, ItemRepository $itemRepository, CategoryRepository $CategoryRepository)
    {
        $searchTerm = $request->query->get('q');
        $categoryId = $request->query->get('category_id');
        $startingPrice = $request->query->get('starting_price');
        $startingTime = $request->query->get('starting_time');
        $endingTime = $request->query->get('ending_time');
    
        $items = [];
        if (!empty($searchTerm)) {
            $items = $itemRepository->searchItems($searchTerm);
        }
        elseif (!empty($categoryId) || !empty($startingPrice) || !empty($startingTime) || !empty($endingTime)) {
            $items = $itemRepository->advancedSearch($startingTime, $endingTime, $startingPrice, $categoryId);
        }
        else{
            $items = $itemRepository->findAll();
        }
    
        return $this->render('Item/show.html.twig', [
            'items' => $items,
            'searchTerm' => $searchTerm,
            'categoryId' => $categoryId,
            'startingPrice' => $startingPrice,
            'startingTime' => $startingTime,
            'endingTime' => $endingTime,
            'categories' => $CategoryRepository->findAll(),
        ]);
    }
    #[Route('/change-language', name: 'change_language')]
public function changeLanguage(Request $request): Response
{
    // Get the selected language from the form data
    $language = $request->request->get('language');

    // Set the language in the session
    $request->getSession()->set('_locale', $language);

    // Redirect back to the previous page
    return $this->redirectToRoute('app_home');
}

    // public function search(Request $request, ItemRepository $itemRepository)
    // {
    //     $searchTerm = $request->query->get('q');
    //     $items = $itemRepository->searchItems($searchTerm);
    
    //     return $this->render('search.html.twig', [
    //         'items' => $items,
    //         'searchTerm' => $searchTerm,
    //     ]);
    // }
    

}


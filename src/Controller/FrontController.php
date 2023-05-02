<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Doctrine\Persistence\ManagerRegistry; 
use App\Entity\Category;
use App\Entity\Item;
use App\Entity\Bids;
use App\Entity\utilisateur;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\ItemRepository;
use App\Repository\BidsRepository;
use Symfony\Component\HttpFoundation\Request;
use App\Repository\CategoryRepository;
use MercurySeries\FlashyBundle\FlashyNotifier;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use App\Form\EditProfileType;

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
            'controller_name' => 'FrontController',
            'categories' => $categories,
            'items' => $items,
            
            
        ]);
    }

    #[Route('/items', name: 'list_client')]
    public function showItem(Request $request, ItemRepository $itemRepository, CategoryRepository $CategoryRepository,FlashyNotifier $flashy)
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
        $flashBag = $request->getSession()->getFlashBag();
        $flashyMessage = $flashBag->get('success');

    
        return $this->render('Item/show.html.twig', [
            'items' => $items,
            'searchTerm' => $searchTerm,
            'categoryId' => $categoryId,
            'startingPrice' => $startingPrice,
            'startingTime' => $startingTime,
            'endingTime' => $endingTime,
            'categories' => $CategoryRepository->findAll(),
            'flashyMessage' => $flashyMessage,
        ]);
    }

    #[Route('/won', name: 'won_items')]
    public function showWonItems(): Response
    {
        $user = $this->getUser();
    
        // Retrieve the items won by the user
        $items = $this->getDoctrine()->getRepository(Item::class)->findWonItemsByUser($user);
    
        // Get the last bid for each item
        $lastBids = [];
        foreach ($items as $item) {
            $lastBid = $this->getDoctrine()->getRepository(Bids::class)->findLastBidForItem($item);
            $lastBids[$item->getId()] = $lastBid;
        }
    
        return $this->render('item/won.html.twig', [
            'items' => $items,
            'lastBids' => $lastBids,
        ]);
    }   
    

    #[Route('/profile', name: 'profile_edit')]
public function editProfile(Request $request, UserPasswordEncoderInterface $passwordEncoder): Response
{
    $user = $this->getUser();
    $form = $this->createForm(EditProfileType::class, $user);
    $form->handleRequest($request);

    if ($form->isSubmitted() && $form->isValid()) {
        $newPassword = $form->get('newPassword')->getData();
        $currentPassword = $form->get('currentPassword')->getData();

        // Authenticate the user with the current password
        $isPasswordValid = $passwordEncoder->isPasswordValid($user, $currentPassword);

        if (!$isPasswordValid) {
            $form->addError(new FormError('Invalid current password.'));
            return $this->render('edit_profile.html.twig', [
                'form' => $form->createView(),
            ]);
        }
        $imageFile = $form->get('img')->getData();

        if ($imageFile) {
            // Set the image name as the current timestamp and the original file extension
            $imageName = time() . '.' . $imageFile->getClientOriginalExtension();

            // Move the file to the configured directory using VichUploader
            $imageFile->move(
                $this->getParameter('user_images_directory'),
                $imageName
            );

            // Update the item entity with the new image filename

            $user->setImg($imageName);
        }

        // Update the user entity with the new password
        if ($newPassword) {
            $encodedPassword = $passwordEncoder->encodePassword($user, $newPassword);
            $user->setPassword($encodedPassword);
        }

        $this->getDoctrine()->getManager()->flush();

        $this->addFlash('success', 'Profile updated successfully.');
        return $this->redirectToRoute('profile_index');
    }

    return $this->render('utilisateur/profile.html.twig', [
        'form' => $form->createView(),
        'user' => $user,
    ]);
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


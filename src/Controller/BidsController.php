<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Item;
use App\Form\BidType;
use App\Repository\ItemRepository;
use Symfony\Component\HttpFoundation\Request;
use App\Repository\BidsRepository;
use App\Entity\Bids;
use Symfony\Component\Security\Core\User\UserInterface;
use MercurySeries\FlashyBundle\FlashyNotifier;

class BidsController extends AbstractController
{

    public function __construct(FlashyNotifier $flashy)
{
    $this->flashy = $flashy;
}

#[Route('/item/{id}/bid/update', name: 'bid_update')]
public function update_bid(Request $request, Item $item, BidsRepository $bidRepository, UserInterface $user): Response
{   
    
    $lastBid = $this->getDoctrine()
    ->getRepository(Bids::class)
    ->findLastBidForItem($item->getId());

    $currentBid = $bidRepository->findOneBy(['item' => $item, 'User' => $user]);
    $form = $this->createForm(BidType::class, $currentBid);
    $form->handleRequest($request);
    
    if ($form->isSubmitted() && $form->isValid()) {
        
        $amount = $currentBid->getAmount();
        
        if (!$lastBid || $amount > $lastBid->getAmount()) {
            $currentBid->setUpdatedAt(new \DateTime());
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($currentBid);
            $entityManager->flush();
            $this->addFlash('success', 'Your bid has been updated!');
            return $this->redirectToRoute('item_show', ['id' => $item->getId()]);
        }
    }

    return $this->render('bids/new.html.twig', [
        'bid' => $currentBid,
        'form' => $form->createView(),
        'lastBid' => $lastBid,
        'lastBidAmount' => $lastBid ? $lastBid->getAmount() : null,
        'item' => $item,
    ]);
}

#[Route('/item/{id}/bid', name: 'bid_on_item')]
public function new(int $id, Request $request, ItemRepository $itemRepository, BidsRepository $bidRepository, UserInterface $user, FlashyNotifier $flashy): Response
{
    $item = $itemRepository->find($id);
    if (!$item) {
        throw $this->createNotFoundException('Item not found');
    }

    $currentBid = $bidRepository->findOneBy(['item' => $item,'User' =>$user]);
    if ($currentBid) {
        return $this->redirectToRoute('bid_update', ['id' => $item->getId()]);
    }

    $lastBid = $bidRepository->findLastBidForItem($item->getId());

    $currentBid = new Bids();
    $currentBid->setItem($item);
    $currentBid->setUser($user);
    $amount = $lastBid ? $lastBid->getAmount() + 1 : $item->getStartingPrice();
    $currentBid->setAmount($amount);

    $form = $this->createForm(BidType::class, $currentBid);
    $form->handleRequest($request);

    if ($form->isSubmitted() && $form->isValid()) {
        $amount = $currentBid->getAmount();
        if ($amount <= $item->getStartingPrice()) {
            $flashy->error('Votre est inferieur au prix du départ', 'http://your-awesome-link.com');
            return $this->redirectToRoute('bid_on_item', ['id' => $item->getId()]);
        }

        if (!$lastBid || $amount > $lastBid->getAmount()) {
            $currentBid->setCreatedAt(new \DateTime());

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($currentBid);
            $entityManager->flush();
            $flashy->success('Votre Enchère est soumis', 'http://your-awesome-link.com');

            return $this->redirectToRoute('list_client', ['id' => $item->getId()]);
        } else {
            $flashy->error('Votre est inferieur au Dernier Prix', 'http://your-awesome-link.com');
            return $this->redirectToRoute('bid_on_item', ['id' => $item->getId()]);
        }
    }


    return $this->render('bids/new.html.twig', [
        'bid' => $currentBid,
        'form' => $form->createView(),
        'lastBid' => $lastBid,
        'lastBidAmount' => $lastBid ? $lastBid->getAmount() : null,
        'item' => $item,
    ]);
}

// public function createBidWinner(Item $item)
// {
//     $lastBid = $this->getDoctrine()->getRepository(Bid::class)->findLastBidForItem($item);
    
//     if ($lastBid) {
//         $entityManager = $this->getDoctrine()->getManager();
        
//         $bidWinner = new BidWinner();
//         $bidWinner->setItem($item);
//         $bidWinner->setBid($lastBid);
//         $bidWinner->setBuyer($lastBid->getBidder());
//         $bidWinner->setAmount($lastBid->getAmount());
        
//         $entityManager->persist($bidWinner);
//         $entityManager->flush();
        
//         return $bidWinner;
//     }
    
//     return null;
// }


}

<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Stripe\Checkout\Session;
use Stripe\Stripe;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use App\Repository\ItemRepository;
use App\Repository\BidsRepository;
use App\Entity\Bids;
use App\Entity\Item;
use Doctrine\ORM\EntityManagerInterface;


class PaymentController extends AbstractController
{
//     #[Route('/checkout/{itemId}', name: 'checkout')]
// public function checkout($stripeSK, $itemId, EntityManagerInterface $entityManager): Response
// {
//     Stripe::setApiKey($stripeSK);

//     // Load the item that was won by the user
//     $item = $entityManager->find(Item::class, $itemId);

//     $session = Session::create([
//         'payment_method_types' => ['card'],
//         'line_items'           => [
//             [
//                 'price_data' => [
//                     'currency'     => 'usd',
//                     'product_data' => [
//                         'name' => $item->getName(),
//                     ],
//                     'unit_amount'  => $item->findLastBidForItem()->getAmount(),
//                 ],
//                 'quantity'   => 1,
//             ]
//         ],
//         'mode'                 => 'payment',
//         'success_url'          => $this->generateUrl('success_url', [], UrlGeneratorInterface::ABSOLUTE_URL),
//         'cancel_url'           => $this->generateUrl('cancel_url', [], UrlGeneratorInterface::ABSOLUTE_URL),
//     ]);

//     // Update the status of the item to 2
//     $item->setStatus(2);
//     $entityManager->flush();

//     return $this->redirect($session->url, 303);
// }

    #[Route('/checkout/{itemId}', name: 'checkout')]
    public function checkout($stripeSK, $itemId,EntityManagerInterface $entityManager): Response
    {
        Stripe::setApiKey($stripeSK);
    
        $item = $entityManager->find(Item::class, $itemId);
    
        if (!$item) {
            throw $this->createNotFoundException('Item not found');
        }
    
        $lastBid = $entityManager->getRepository(Bids::class)->findLastBidForItem($item);
    
        $session = Session::create([
            'payment_method_types' => ['card'],
            'line_items'           => [
                [
                    'price_data' => [
                        'currency'     => 'usd',
                        'product_data' => [
                            'name' => $item->getName(),
                            
                        ],
                        'unit_amount'  => $lastBid->getAmount()* 100 *3.2,
                    ],
                    'quantity'   => 1,
                ]
            ],
            'mode'                 => 'payment',
            'success_url'          => $this->generateUrl('success_url', [], UrlGeneratorInterface::ABSOLUTE_URL),
            'cancel_url'           => $this->generateUrl('cancel_url', [], UrlGeneratorInterface::ABSOLUTE_URL),
        ]);
         // Update the status of the item to 2
       $item->setStatus(2);
        $entityManager->flush();

    
        return $this->redirect($session->url, 303);
    }
    
    #[Route('/success-url', name: 'success_url')]
    public function successUrl(): Response
    {
        return $this->render('payment/success.html.twig', []);
    }


    #[Route('/cancel-url', name: 'cancel_url')]
    public function cancelUrl(): Response
    {
        return $this->render('payment/cancel.html.twig', []);
    }
}

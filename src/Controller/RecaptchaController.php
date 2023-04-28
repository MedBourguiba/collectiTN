<?php


namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class RecaptchaController extends AbstractController
{
    /**
     * @Route("/verify-recaptcha", name="verify_recaptcha")
     */
    public function verifyRecaptcha(Request $request)
    {
        if ($request->isMethod('POST')) {
            $recaptchaResponse = $request->request->get('g-recaptcha-response');
            $url = 'https://www.google.com/recaptcha/api/siteverify';
            $data = [
                'secret' => '6LfhRMUlAAAAAHwg3O_bttVnj5aVdV4X6o6oX4aX',
                'response' => $recaptchaResponse,
                'remoteip' => $request->getClientIp(),
            ];

            $options = [
                'http' => [
                    'header' => 'Content-type: application/x-www-form-urlencoded',
                    'method' => 'POST',
                    'content' => http_build_query($data),
                ],
            ];

            $context = stream_context_create($options);
            $result = file_get_contents($url, false, $context);
            $resultJson = json_decode($result);

          
        } else {
            // Show an error message and ask the user to try again
        }
    }
}
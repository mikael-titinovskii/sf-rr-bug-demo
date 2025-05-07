<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Exception\SessionNotFoundException;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;

final class TestController extends AbstractController
{
    #[Route('/test', name: 'app_test')]
    public function index(
        Request $request
    ): JsonResponse
    {
        $pid = getmypid();
        $session = $request->getSession();
        if (rand(0,1) === 0 && $session->get('client') === '1'){
            throw new \Exception("Test exception pid( $pid )");
        }

        // here we set the client var from the get param
        if (!$session->has('client')) {
            $session->set('client', $request->get('client'));
        }

        return $this->json([
            'session_id' => $session?->getId(),
            'pid' => $pid,
            'cr' => $request->get('client'),
            'cs' => $session->get('client'),
            'match' => $request->get('client') === $session->get('client') ? 'yes' : 'no ***',
        ]);
    }
}

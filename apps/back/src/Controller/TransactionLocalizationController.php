<?php


namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class TransactionLocalizationController extends AbstractController
{
    /**
     * @Route("/api/transactions/localization", name="transaction_localization", methods={"POST"})
     */
    public function updateTransactionLocation(Request $request): JsonResponse
    {
        $latitude = $request->request->get('latitude');
        $longitude = $request->request->get('longitude');
        return $this->json(['message' => 'Transaction location updated successfully']);
    }
}
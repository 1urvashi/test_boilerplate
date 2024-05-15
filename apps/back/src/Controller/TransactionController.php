<?php
namespace App\Controller;

use App\Entity\Transaction;
use App\Service\GooglePlacesService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class TransactionController extends AbstractController
{
    private $googlePlacesService;

    public function __construct(GooglePlacesService $googlePlacesService)
    {
        $this->googlePlacesService = $googlePlacesService;
    }

    /**
     * @Route("/api/transactions", name="api_transactions", methods={"GET"})
     */
    public function getTransactions()
    {
        // Fetch transactions from the database
        $transactions = $this->getDoctrine()->getRepository(Transaction::class)->findAll();

        $data = [];
        foreach ($transactions as $transaction) {
            $data[] = [
                'id' => $transaction->getId(),
                'description' => $transaction->getDescription(),
                'amount' => $transaction->getAmount(),
            ];
        }

        return new JsonResponse($data);
    }

    /**
     * @Route("/transactions", name="transactions_list", methods={"GET"})
     */
    public function listTransactions(): JsonResponse
    {
        // Retrieve the logged-in user
        $user = $this->getUser();
        
        // Get transactions for the logged-in user
        $transactions = $this->getDoctrine()
            ->getRepository(Transaction::class)
            ->findBy(['userId' => $user->getId()]);
        
        return $this->json($transactions);
    }

    /**
     * @Route("/transactions/locations", name="transaction_locations", methods={"GET"})
     */
    public function getNearbyLocations(Request $request, int $id)
    {
        $transaction = $this->getDoctrine()->getRepository(Transaction::class)->find($id);

        if (!$transaction) {
            return new JsonResponse(['error' => 'Transaction not found'], JsonResponse::HTTP_NOT_FOUND);
        }

        // Fetch nearby locations using Google Places API
        $nearbyLocations = $this->googlePlacesService->getNearbyLocations($transaction->getLatitude(), $transaction->getLongitude());

        return new JsonResponse($nearbyLocations);
    }


    /**
     * @Route("/transactions/localization", name="transaction_localization", methods={"POST"})
     */
    public function handleTransactionLocalization(Request $request): JsonResponse
    {
        $transactionId = $request->request->get('transaction_id');
        $selectedLocation = $request->request->get('selected_location');

        $transaction = $this->getDoctrine()->getRepository(Transaction::class)->find($transactionId);
        $transaction->updateLocation($selectedLocation);

        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($transaction);
        $entityManager->flush();

        return $this->json(['message' => 'Transaction location updated successfully']);
    }
}
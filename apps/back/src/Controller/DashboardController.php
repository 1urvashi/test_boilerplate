<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

class DashboardController extends AbstractController
{
    /**
     * @Route("/dashboard", name="dashboard", methods={"GET"})
     */
    public function dashboard(): JsonResponse
    {
        $userScores = $this->calculateUserScores();
        $pendingTransactionsCount = $this->getPendingTransactionsCount();

        // Return dashboard data
        return $this->json([
            'user_scores' => $userScores,
            'pending_transactions_count' => $pendingTransactionsCount
        ]);
    }

    private function calculateUserScores(): array
    {
        $userScores = [
            'user1' => 100,
            'user2' => 80,
        ];

        return $userScores;
    }

    private function getPendingTransactionsCount(): int
    {
        $pendingTransactionsCount = 10; // Sample pending transactions count

        return $pendingTransactionsCount;
    }
}

<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

class AdminUserController extends AbstractController
{
    /**
     * @Route("/admin/users", name="admin_users", methods={"GET"})
     */
    public function getUsers(): JsonResponse
    {
        $users = $this->getDoctrine()->getRepository(User::class)->findAll();

        return $this->json($users);
    }
}
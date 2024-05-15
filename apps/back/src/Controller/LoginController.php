<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class LoginController extends AbstractController
{
    /**
     * @Route("/login", name="login", methods={"POST"})
     */
    public function login(Request $request): Response
    {
        $data = json_decode($request->getContent(), true);

        $username = $data['username'] ?? null;
        $password = $data['password'] ?? null;

        // Check if username and password are provided
        if (!$username || !$password) {
            return new Response('Username and password are required', Response::HTTP_BAD_REQUEST);
        }

        if ($username === 'admin' && $password === 'password') {
            // Authentication successful
            return new Response('Authentication successful', Response::HTTP_OK);
        } else {
            // Authentication failed
            return new Response('Invalid username or password', Response::HTTP_UNAUTHORIZED);
        }
    }
}
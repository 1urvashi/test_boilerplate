<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class SecurityController extends AbstractController
{
    private $passwordEncoder;

    public function __construct(UserPasswordEncoderInterface $passwordEncoder)
    {
        $this->passwordEncoder = $passwordEncoder;
    }

    public function login(Request $request)
    {
        // Get credentials from the request
        $credentials = json_decode($request->getContent(), true);

        // Authenticate user (custom logic)
        $user = $this->authenticateUser($credentials);

        if (!$user) {
            throw new AuthenticationException('Invalid credentials');
        }

        // Generate JWT token or session
        $token = 'YOUR_GENERATED_TOKEN';

        return new JsonResponse(['token' => $token]);
    }

    private function authenticateUser(array $credentials): ?UserInterface
    {
        $user = $this->getDoctrine()->getRepository(User::class)->findOneBy(['email' => $credentials['email']]);

        if (!$user || !$this->passwordEncoder->isPasswordValid($user, $credentials['password'])) {
            return null;
        }

        return $user;
    }

    public function logout(): Response
    {
        return new RedirectResponse($this->generateUrl('homepage'));
    }
}
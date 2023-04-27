<?php

namespace App\Controller;

use App\Entity\User;
use App\Helpers\Filters;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AuthController extends AbstractController
{
    #[Route('/api/auth/register', name: "register", methods: ['POST'])]
    public function createUser(Request $request, UserRepository $entityRepository): Response
    {
        // Récupérer les données du formulaire
        $data = json_decode($request->getContent(), true);

        // Créer une nouvelle instance de l'entité User
        $user = (new User())
            ->setUsername($data['username'])
            ->setEmail($data['email'])
            ->setPassword(password_hash($data['password'], PASSWORD_DEFAULT))
            ->setCreatedAt(new \DateTimeImmutable());

        // Persister l'entité dans la base de données
        $entityRepository->save($user, true);

        // Retourner une réponse
        return $this->json(
            [
                $user,
                'token' => $jwt,
                'message' => 'user created'
            ], Response::HTTP_CREATED
        );
    }
}

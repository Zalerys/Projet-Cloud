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

    #[Route("/api/auth/register", name: "register", methods: ['POST'])]
    public function register(): void
    {
        if (!empty(Filters::postString('password')) && !empty(Filters::postString('password-confirm')) && Filters::postString('password') === Filters::postString('password-confirm')) {
            try {
                $user = new User([
                    'username' => strtolower(Filters::postString('username')),
                    'email' => strtolower(Filters::postString('email')),
                ]);

                $user->setHashedPassword(password_hash(Filters::postString('password'), PASSWORD_DEFAULT));
                $user = (new UserManager(new PDOFactory()))->insertOne($user);
                $jwt = JWTHelper::buildJWT($user);
                http_response_code(201);
                $this->json([
                    "token" => $jwt,
                    "message" => "user created"
                ]);

            } catch (UserException $e) {
                http_response_code(403);
                $this->json([
                    "message" => "user already exists"
                ]);
            }
        } else {
            http_response_code(406);
            $this->json([
                "message" => "passwords do not match"
            ]);
        }
    }
}

<?php

namespace App\Controller;

use App\Entity\User;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;

class UserController extends AbstractController
{
    // Get user details
    #[Route('/api/users/{id}', name: 'user_details')]
    public function user_details(): JsonResponse
    {
        return $this->json([
            'message' => 'Welcome to your new controller!',
            'path' => 'src/Controller/UserController.php',
        ]);
    }

    #[Route('/api/users', name: 'user_list', methods: ['GET'])]
    public function userList(SerializerInterface $serializer, UserRepository $userRepository): JsonResponse
    {
        $users = $userRepository->findAll();
        $jsonUsers = $serializer->serialize($users, 'json');
        return new JsonResponse($jsonUsers, Response::HTTP_OK, [], true);
    }

    #[Route('/api/users/{id}', name: 'user_details', methods: ['GET'])]
    public function userView(int $id, SerializerInterface $serializer, UserRepository $userRepository): JsonResponse
    {
        $user = $userRepository->find($id);
        if ($user) {
            $jsonUser = $serializer->serialize($user, 'json', ['groups' => 'user_single']);
            return new JsonResponse($jsonUser, Response::HTTP_OK, [], true);
        }
        return new JsonResponse(null, Response::HTTP_NOT_FOUND);
    }

    #[Route('/api/users', name: "create_user", methods: ['POST'])]
    public function createUser(Request $request, UserRepository $entityRepository): Response
    {
        // Récupérer les données du formulaire
        $data = json_decode($request->getContent(), true);

        // Créer une nouvelle instance de l'entité User
        $user = (new User())
            ->setUsername($data['username'])
            ->setEmail($data['email'])
            ->setPassword($data['password'])
            ->setCreatedAt(new \DateTimeImmutable());

        // Persister l'entité dans la base de données
        $entityRepository->save($user, true);

        // Retourner une réponse
        return $this->redirectToRoute('user_list');
    }

    #[Route('/api/users/pwd/{id}', name: "update_pwd_user", methods: ['PUT'])]
    public function modifyPassword(int $id, Request $request, UserRepository $entityRepository, User $user): Response {
        //Verifier si l'utilisateur existe
        $user = $entityRepository->find($id);
        if (!$user) {
            return $this->json([
                'error' => 'L\'utilisateur n\'existe pas'
            ], Response::HTTP_NOT_FOUND);
        }

        // Récupérer les données du formulaire
        $data = json_decode($request->getContent(), true);

        // Créer une nouvelle instance de l'entité User
        $user->setPassword($data['password']);

        // Persister l'entité dans la base de données
        $entityRepository->save($user, true);

        // Retourner une réponse
        return $this->redirectToRoute('user_details', ['id' => $user->getId()]);
    }

    #[Route('/api/users/{id}', name: "delete_user", methods: ['DELETE'])]
    public function deleteUser(int $id, Request $request, UserRepository $entityRepository, User $user): Response {
        //Verifier si l'utilisateur existe
        $user = $entityRepository->find($id);
        if (!$user) {
            return $this->json([
                'error' => 'L\'utilisateur n\'existe pas'
            ], Response::HTTP_NOT_FOUND);
        }

        //Supprimer l'utilisateur
        $entityRepository->remove($user, true);

        //Retourner une réponse
        return new JsonResponse(null, Response::HTTP_NO_CONTENT);

    }
}

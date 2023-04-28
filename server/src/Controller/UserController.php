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
    #[Route('/api/users', name: 'user_list', methods: ['GET'])]
    public function userList(SerializerInterface $serializer, UserRepository $userRepository): JsonResponse
    {
        $users = $userRepository->findAll();
        $jsonUsers = $serializer->serialize($users, 'json', ['groups' => 'user_list']);
        return new JsonResponse($jsonUsers, Response::HTTP_OK, [], true);
    }

    #[Route('/api/users/{id}', name: 'user_details', methods: ['GET'])]
    public function userDetails(int $id, SerializerInterface $serializer, UserRepository $userRepository): JsonResponse
    {
        $user = $userRepository->find($id);
        if ($user) {
            $jsonUser = $serializer->serialize($user, 'json', ['groups' => 'user_single']);
            return new JsonResponse($jsonUser, Response::HTTP_OK, [], true);
        }
        return new JsonResponse(null, Response::HTTP_NOT_FOUND);
    }

    #[Route('/api/users/pwd', name: "update_pwd_user", methods: ['PUT'])]
    public function modifyPassword(Request $request, SerializerInterface $serializer, UserRepository $entityRepository, User $user): Response {
        $data = json_decode($request->getContent(), true);

        $token = $request->headers->get('Authorization');
        $token = str_replace('Bearer ', '', $token);
        $token = explode('.', $token)[1];
        $token = base64_decode($token);
        $token = json_decode($token, true);
        $user = $entityRepository->findOneBy(['username' => $token['username']]);

        if ($user && !empty($data['password'])) {
            $user->setPassword(password_hash($data['password'], PASSWORD_DEFAULT));

            $entityRepository->save($user, true);

            $jsonUser = $serializer->serialize($user, 'json', ['groups' => 'user_single']);
            return new JsonResponse($jsonUser, Response::HTTP_OK, [], true);
        }
        return new JsonResponse(null, Response::HTTP_BAD_REQUEST);
    }


    #[Route('/api/users/ssh', name: "add_ssh_user", methods: ['PUT'])]
    public function addSshKeyUser(Request $request, UserRepository $entityRepository, User $user): Response {
        // Récupérer les données du formulaire
        $data = json_decode($request->getContent(), true);

        // Récupérer l'utilisateur avec le jwt token
        $token = $request->headers->get('Authorization');
        $token = str_replace('Bearer ', '', $token);
        $token = explode('.', $token)[1];
        $token = base64_decode($token);
        $token = json_decode($token, true);
        $user = $entityRepository->findOneBy(['username' => $token['username']]);

        // Créer une nouvelle instance de l'entité User
        if (!empty($data['sshKey'])) $user->setPublicSshKey($data['sshKey']);

        // Persister l'entité dans la base de données
        $entityRepository->save($user, true);

        // Retourner une réponse
        return new JsonResponse(null, Response::HTTP_NO_CONTENT);
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

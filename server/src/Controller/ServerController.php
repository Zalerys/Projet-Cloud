<?php

namespace App\Controller;

use App\Entity\Database;
use App\Entity\Server;
use App\Repository\DatabaseRepository;
use App\Repository\ServerRepository;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;

class ServerController extends AbstractController
{
    #[Route('/servers', name: 'server_list', methods: ['GET'])]
    public function serverList(SerializerInterface $serializer, ServerRepository $serverRepository): JsonResponse
    {
        $servers = $serverRepository->findAll();
        $jsonServers = $serializer->serialize($servers, 'json', ['groups' => 'server_list']);
        return new JsonResponse($jsonServers, Response::HTTP_OK, [], true);
    }

    #[Route("/server/{id}", name: "server-details", methods: ['GET'])]
    public function serverView(int $id, SerializerInterface $serializer, ServerRepository $serverRepository): JsonResponse
    {
        $server = $serverRepository->find($id);
        if ($server) {
            $jsonServer = $serializer->serialize($server, 'json', ['groups' => 'server_single']);
            return new JsonResponse($jsonServer, Response::HTTP_OK, [], true);
        }
        return new JsonResponse(null, Response::HTTP_NOT_FOUND);
    }

    #[Route('/server/{id}', name: "create_server", methods: ['POST'])]
    public function createServer(int $id, Request $request, ServerRepository $serverRepository, UserRepository $userRepository, DatabaseRepository $databaseRepository): Response
    {
        // Récupérer les données du formulaire
        $data = json_decode($request->getContent(), true);

        // Récupérer l'utilisateur
        $user = $userRepository->find($id);

        // Créer une nouvelle instance de l'entité User
        $server = (new Server())
            ->setName($data['name'])
            ->setStorageSize($data['storage_size'])
            ->setBackupsFolderPath($data['backups_folder_path'])
            ->setAutoBackupsTime(new \DateTimeImmutable())
            ->setCreatedAt(new \DateTimeImmutable())
            ->addUser($user);

        $db = (new Database())
            ->setName("db_". $data['name'])
            ->setServer($server)
            ->setCreatedAt(new \DateTimeImmutable())
            ->addUser($user);

        // Persister l'entité dans la base de données
        $databaseRepository->save($db);
        $serverRepository->save($server, true);

        // Retourner une réponse
        return new Response('Server created', Response::HTTP_CREATED);

    }

    #[Route('/server/{id}', name: "delete_server", methods: ['DELETE'])]
    public function deleteServer(int $id) {

    }
}

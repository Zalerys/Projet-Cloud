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
    #[Route('/api/servers', name: 'server_list', methods: ['GET'])]
    public function serverList(SerializerInterface $serializer, ServerRepository $serverRepository): JsonResponse
    {
        $servers = $serverRepository->findAll();
        $jsonServers = $serializer->serialize($servers, 'json', ['groups' => 'server_list']);
        return new JsonResponse($jsonServers, Response::HTTP_OK, [], true);
    }

    #[Route("/api/servers/{id}", name: "server-details", methods: ['GET'])]
    public function serverDetails(int $id, SerializerInterface $serializer, ServerRepository $serverRepository): JsonResponse
    {
        $server = $serverRepository->find($id);
        if ($server) {
            $jsonServer = $serializer->serialize($server, 'json', ['groups' => 'server_single']);
            return new JsonResponse($jsonServer, Response::HTTP_OK, [], true);
        }
        return new JsonResponse(null, Response::HTTP_NOT_FOUND);
    }

    #[Route('/api/servers', name: "create_server", methods: ['POST'])]
    public function createServer(Request $request, SerializerInterface $serializer, ServerRepository $serverRepository, UserRepository $userRepository, DatabaseRepository $databaseRepository): Response
    {
        // Récupérer les données du formulaire
        $data = json_decode($request->getContent(), true);

        // Récupérer l'utilisateur avec le jwt token
        $token = $request->headers->get('Authorization');
        $token = str_replace('Bearer ', '', $token);
        $token = explode('.', $token)[1];
        $token = base64_decode($token);
        $token = json_decode($token, true);
        $user = $userRepository->findOneBy(['username' => $token['username']]);

        // Créer une nouvelle instance de l'entité User
        $server = new Server();
        $server->setCreatedAt(new \DateTimeImmutable());
        $server->addUser($user);
        if (!empty($data['name'])) $server->setName($data['name']); else return new JsonResponse(null, Response::HTTP_BAD_REQUEST);
        if (!empty($data['storage_size'])) $server->setStorageSize($data['storage_size']);
        if (!empty($data['backups_folder_path'])) $server->setBackupsFolderPath($data['backups_folder_path']);
        if (!empty($data['auto_backups_time'])) $server->setAutoBackupsTime(new \DateTimeImmutable());

        $db = new Database();
        $db->setName("db_". $data['name']);
        $db->setCreatedAt(new \DateTimeImmutable());
        $db->addUser($user);
        $db->setServer($server);

        // Persister l'entité dans la base de données
        $databaseRepository->save($db);
        $serverRepository->save($server, true);

        // Retourner une réponse
        if ($user) {
            $jsonServer = $serializer->serialize($server, 'json', ['groups' => 'server_single']);
            $jsonDatabase = $serializer->serialize($db, 'json', ['groups' => 'database_single']);

            $cleanServer = json_decode($jsonServer, true);
            $cleanDatabase = json_decode($jsonDatabase, true);

            $jsonReturn = $serializer->serialize(['server' => $cleanServer, 'database' => $cleanDatabase], 'json');
            return new JsonResponse($jsonReturn, Response::HTTP_CREATED, [], true);
        }
        return new JsonResponse(null, Response::HTTP_NOT_FOUND);
    }

    #[Route('/api/servers/{id}', name: "delete_server", methods: ['DELETE'])]
    public function deleteServer(int $id, Request $request, SerializerInterface $serializer, ServerRepository $serverRepository) {
        //Verifier si l'utilisateur existe
        $server = $serverRepository->find($id);

        if ($server) {
            try {
                $serverRepository->remove($server, true);

                return $this->json([
                    'message' => 'Delete success'
                ], Response::HTTP_OK);
            } catch (\Exception $e) {
                return $this->json([
                    'message' => 'Delete failed'
                ], Response::HTTP_INTERNAL_SERVER_ERROR);
            }

        }

        //Retourner une réponse
        return $this->json([
            'error' => 'Server not found'
        ], Response::HTTP_NOT_FOUND);

    }
}

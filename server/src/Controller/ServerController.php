<?php

namespace App\Controller;

use App\Entity\Server;
use App\Repository\ServerRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
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

    #[Route("/server/{id}", name: "server_details", methods: ['GET'])]
    public function serverView(int $id, SerializerInterface $serializer, ServerRepository $serverRepository): JsonResponse
    {
        $server = $serverRepository->find($id);
        if ($server) {
            $jsonServer = $serializer->serialize($server, 'json', ['groups' => 'server_single']);
            return new JsonResponse($jsonServer, Response::HTTP_OK, [], true);
        }
        return new JsonResponse(null, Response::HTTP_NOT_FOUND);
    }

    #[Route('/server/{token}', name: "create_server", methods: ['POST'])]
    public function createServer(string $token, SerializerInterface $serializer, ServerRepository $serverRepository) {

    }

    #[Route('/server/{id}', name: "delete_server", methods: ['DELETE'])]
    public function deleteServer(int $id) {

    }
}

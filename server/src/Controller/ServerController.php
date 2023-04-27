<?php

namespace App\Controller;

use App\Repository\ServerRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;

class ServerController extends AbstractController
{
    #[Route('/server', name: 'app_server', methods: ['POST'])]
    public function index(): JsonResponse
    {
        return $this->json([
            'message' => 'Welcome to your new controller!',
            'path' => 'src/Controller/ServerController.php',
        ]);
    }

    #[Route("/server/{id}", name: "server-details", methods: ['GET'])]
    public function serverView(int $id, SerializerInterface $serializer, ServerRepository $serverRepository): JsonResponse
    {
        $server = $serverRepository->find($id);
        if ($server) {
            $jsonServer = $serializer->serialize($server, 'json');
            return new JsonResponse($jsonServer, Response::HTTP_OK, [], true);
        }
        return new JsonResponse(null, Response::HTTP_NOT_FOUND);
    }

    #[Route('/server/{token}', name: "create_server", methods: ['POST'])]
    public function createServer(string $token) {

    }

    #[Route('/server/{id}', name: "delete_server", methods: ['DELETE'])]
    public function deleteServer(int $id) {

    }
}

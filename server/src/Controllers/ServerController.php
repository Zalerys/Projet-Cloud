<?php

namespace App\Controllers;

use App\Entities\Server;
use App\Exceptions\ServerException;
use App\Factories\PDOFactory;
use App\Framework\Entity\BaseController;
use App\Framework\Route\Route;
use App\Helpers\Tools;
use App\Managers\ServerManager;
use App\Types\HttpMethods;
use Exception;

class ServerController extends BaseController
{
    #[Route("/servers/{id}", name: "server-details", methods: [HttpMethods::GET])]
    public function serverView(int $id): void
    {
        $server = null;
        try {
            $server = (new ServerManager(new PDOFactory()))->findOne($id);

            http_response_code(200);
            $this->renderJSON([
                "server" => $server->toArray(),
            ]);
        }
        catch (Exception $e) {
            http_response_code(404);
            $this->renderJSON([
                "message" => "server not found"
            ]);
        }
    }

    #[Route('/servers', name: "create_server", methods: [HttpMethods::POST])]
    public function createServer() {
        try {
            $server = (new ServerManager(new PDOFactory()))->insertOne(new Server($_POST));

            //script addServeur
            //script createDB

            $data = [
                "message" => "server created",
                "server" => $server->toArray()
            ];
            $this->renderJSON($data);
        } catch (ServerException $e) {
            http_response_code(400);
            $this->renderJSON([
                "message" => $e->getMessage()
            ]);
        }
    }

    #[Route('/servers/{id}', name: "delete_server", methods: [HttpMethods::DELETE])]
    public function deleteServer(int $id) {
        try {
            // user verification

            (new ServerManager(new PDOFactory()))->deleteOne($id);

            //script deleteServeur
            //script deleteDB

            $data = [
                "message" => "server deleted",
            ];
            $this->renderJSON($data);
        } catch (ServerException $e) {
            http_response_code(500);
            $this->renderJSON([
                "message" => $e->getMessage()
            ]);
        }
    }
}
